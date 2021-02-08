<?php
include_once('../classes/form_handlers/TicketValidator.class.php');

class CreateTicketHandler extends TicketValidator
{
    public function process_input()
    {
        $this->validate_title_and_description();
        $this->validate_other();

        if (!$this->errors) {
            $this->validate_title_unique('create');
        }
        if (!$this->errors) {
            $this->create();
            $this->redirect();
        } else {
            return $this->errors;
        }
    }

    private function validate_other()
    {
        if (!isset($this->new_ticket['project_id'])) {
            $this->add_error('project', 'Choose project');
        }
        if (!isset($this->new_ticket['priority_id'])) {
            $this->add_error('priority', 'Choose priority');
        }
        if (!isset($this->new_ticket['type_id'])) {
            $this->add_error('type', 'Choose type');
        }
        if (!isset($this->new_ticket['status_id'])) {
            $this->add_error('status', 'Choose status');
        }
        if (!isset($this->new_ticket['developer_assigned'])) {
            $this->add_error('developer', 'Choose developer');
        }
    }

    private function create()
    {
        $this->contr->create_ticket($this->new_ticket);
        $developer_is_enrolled_in_project = $this->contr->check_project_enrollment($this->new_ticket['project_id'], $this->new_ticket['developer_assigned']);
        if (!$developer_is_enrolled_in_project) {
            $this->contr->assign_to_project($this->new_ticket['developer_assigned'], $this->new_ticket['project_id']);
            $project_name = $this->contr->get_project_name_by_id($this->new_ticket['project_id'])['project_name'];
            $message = "enrolled you in the project '{$project_name}'";
            $this->contr->create_notification(4, $this->new_ticket['developer_assigned'], $message, $this->new_ticket['submitter']);
        }
        $message = "assigned you to the ticket '{$this->new_ticket['title']}'";
        $this->contr->create_notification(2, $this->new_ticket['developer_assigned'], $message, $this->new_ticket['submitter']);
    }

    private function redirect()
    {   //dette skal laves om til sesssion og get[project_id gerne i url]
        //husk også at slette referencen til $_POST i project_details....
        echo "              
            <form action='project_details.php' method='post' id='form'>
                <input type='hidden' name='project_id' value='{$this->new_ticket['project_id']}'>
                <input type='hidden' name='show_created_ticket_succes_message'>
                <input type='hidden' name='ticket_title' value='{$this->new_ticket['title']}'>
                <input type='hidden' name='ticket_description' value='{$this->new_ticket['description']}'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>
            ";
    }
}
