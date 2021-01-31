<?php
class EditTicketHandler
{
    private $old_ticket;
    private $new_ticket;
    private $errors = [];

    public function __construct($ticket, $post_data)
    {
        $this->old_ticket = $ticket;
        $this->new_ticket = $post_data;
    }

    public function process_input()
    {
        $this->validate_title();
        $this->validate_description();

        if (!$this->errors) {
            $this->attempt_edit();
        }

        if(!$this->errors){
            $this->redirect();
        }

        return $this->errors;
    }

    private function validate_title()
    {

        $val = trim($this->new_ticket['title']);

        if (empty($val)) {
            $this->add_error('title', 'Ticket needs a title');
        } else {
            if (!(strlen($val) < 45 && strlen($val) > 5)) {
                $this->add_error('title', 'Title must be 6-45 chars');
            }
        }
    }

    private function validate_description()
    {

        $val = trim($this->new_ticket['description']);

        if (empty($val)) {
            $this->add_error('description', 'Ticket needs a description');
        } else {
            if (!(strlen($val) < 300 && strlen($val) > 5)) {
                $this->add_error('description', 'Description must be 6-300 chars');
            }
        }
    }

    private function attempt_edit()
    {
        $changes = False;
        $contr = new Controller();
        $old_ticket = $this->old_ticket;
        $new_ticket = $this->new_ticket;
        $ticket_id = $this->old_ticket['ticket_id'];

        
        $new_ticket['project_name'] = $contr-> get_project_name_by_id($new_ticket['project'])['project_name'];
        $new_ticket['priority_name'] = $contr-> get_priority_name_by_id($new_ticket['priority'])['ticket_priority_name'];
        $new_ticket['ticket_type_name'] = $contr-> get_ticket_type_name_by_id($new_ticket['type'])['ticket_type_name'];
        $new_ticket['ticket_status_name'] = $contr-> get_ticket_status_name_by_id($new_ticket['status'])['ticket_status_name'];
        $new_ticket['developer_name'] = $contr-> get_user_by_id($new_ticket['developer_assigned'])['full_name'];

        //print_r($new_ticket['ticket_status_name']);
        //  exit();
        
        if ($old_ticket['title'] != $new_ticket['title']) {
            $contr->add_to_ticket_history($ticket_id, "TitleChange", $old_ticket['title'], $new_ticket['title']);
            $changes = True;
        }
        if (trim($old_ticket['description']) != trim($new_ticket['description'])) {
            $contr->add_to_ticket_history($ticket_id, "DescriptionChange", $old_ticket['description'], $new_ticket['description']);
            $changes = True;
        }
        if ($old_ticket['project'] != $new_ticket['project']) {
            $contr->add_to_ticket_history($ticket_id, "ProjectChange", $old_ticket['project_name'], $new_ticket['project_name']);
            $changes = True;
        }
        if ($old_ticket['priority'] != $new_ticket['priority']) {
            $contr->add_to_ticket_history($ticket_id, "PriorityChange", $old_ticket['ticket_priority_name'], $new_ticket['priority_name']);
            $changes = True;
        }
        if ($old_ticket['type'] != $new_ticket['type']) {
            $contr->add_to_ticket_history($ticket_id, "TypeChange", $old_ticket['ticket_type_name'], $new_ticket['ticket_type_name']);
            $changes = True;
        }
 
        if ($old_ticket['status'] != $new_ticket['status']) {
            $contr->add_to_ticket_history($ticket_id, "StatusChange", $old_ticket['ticket_status_name'], $new_ticket['ticket_status_name']);
            $changes = True;
        }
        
        if ($old_ticket['developer_assigned'] != $new_ticket['developer_assigned']) {
            $contr->add_to_ticket_history($ticket_id, "AssignedTo", $old_ticket['developer_name'], $new_ticket['developer_name']);
            //Notify newly assigned developer
            $message = "assigned you to the ticket '{$new_ticket['title']}'";
            $contr->create_notification(2, $new_ticket['developer_assigned'], $message, $_SESSION['user_id']);
            //Notify previous assigned developer
            $message = "unassigned you from the ticket '{$old_ticket['title']}'";
            $contr->create_notification(3, $old_ticket['developer_assigned'], $message, $_SESSION['user_id']);
            $changes = True;
        }
        if (!$changes) {
            $this->add_error('no_changes_error', 'No changes made to ticket');
        } else {
            $contr->set_ticket($new_ticket);
        }
    }

    private function redirect()
    {
        echo "              
            <form action='ticket_details.php' method='post' id='form'>
                <input type='hidden' name='ticket_id' value='{$this->new_ticket['ticket_id']}'>
                <input type='hidden' name='show_ticket_edited_succes_message'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>";
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
