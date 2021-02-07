<?php
class CreateTicketHandler
{
    private $post_data;
    private $errors = [];
    private $contr;

    public function __construct($post_data)
    {
        $this->post_data = $post_data;
    }

    public function process_input()
    {
        $this->validate_title();
        $this->validate_description();
        $this->validate_other();

        if (!$this->errors) {
            $this->create();
            $this->redirect();
        } else {
            return $this->errors;
        }
    }

    private function validate_title()
    {

        $val = trim($this->post_data['title']);

        if (empty($val)) {
            $this->add_error('title', 'Ticket needs a title');
        } else if (!(strlen($val) < 31 && strlen($val) > 5)) {
            $this->add_error('title', 'Title must be 6-30 chars');
        } else {
            include_once('../includes/auto_loader.inc.php');
            $contr = new Controller();
            $this->contr = $contr;
            if ($contr->get_ticket_by_title($val, $this->post_data['project_id'])) {
                $this->add_error('title', 'Project already has a ticket by that name');
            }
        }
    }

    private function validate_description()
    {
        $val = trim($this->post_data['description']);

        if (empty($val)) {
            $this->add_error('description', 'Ticket needs a description');
        } else {
            if (!(strlen($val) < 201 && strlen($val) > 5)) {
                $this->add_error('description', 'Description must be 6-200 chars');
            }
        }
    }

    private function validate_other()
    {
        if (!isset($this->post_data['project_id'])) {
            $this->add_error('project', 'Choose project');
        }
        if (!isset($this->post_data['priority_id'])) {
            $this->add_error('priority', 'Choose priority');
        }
        if (!isset($this->post_data['type_id'])) {
            $this->add_error('type', 'Choose type');
        }
        if (!isset($this->post_data['status_id'])) {
            $this->add_error('status', 'Choose status');
        }
        if (!isset($this->post_data['developer_assigned'])) {
            $this->add_error('developer', 'Choose developer');
        }
    }

    private function create()
    {
        $contr = $this->contr;
        $contr->create_ticket($this->post_data);
        //Check if developer is enrolled in project
        $check = $contr->check_project_enrollment($this->post_data['project_id'], $this->post_data['developer_assigned']);
        if (!$check) {
            //Enroll developer in project
            $contr->assign_to_project($this->post_data['developer_assigned'], $this->post_data['project_id']);
            //Notify assigned developer
            $project_name = $contr->get_project_name_by_id($this->post_data['project_id'])['project_name'];
            $message = "enrolled you in the project '{$project_name}'";
            $contr->create_notification(4, $this->post_data['developer_assigned'], $message, $this->post_data['submitter']);
        }
        //notify assigned developer
        $message = "assigned you to the ticket '{$this->post_data['title']}'";
        $contr->create_notification(2, $this->post_data['developer_assigned'], $message, $this->post_data['submitter']);
    }

    private function redirect()
    {
        echo "              
            <form action='project_details.php' method='post' id='form'>
                <input type='hidden' name='project_id' value='{$this->post_data['project_id']}'>
                <input type='hidden' name='requested_action' value='show_created_ticket_succes_message'>
                <input type='hidden' name='ticket_title' value='{$this->post_data['title']}'>
                <input type='hidden' name='ticket_description' value='{$this->post_data['description']}'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>
            ";
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
