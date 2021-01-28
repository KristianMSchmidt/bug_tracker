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

        return $this->errors;
    }

    private function validate_title()
    {

        $val = trim($this->new_ticket['title']);

        if (empty($val)) {
            $this->add_error('title', 'Ticket needs a title');
        } else {
            if (!(strlen($val) < 45 && strlen($val) > 5)) {
                $this->add_error('title', 'Title must be 5-45 chars');
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
                $this->add_error('description', 'Description must be 5-300 chars');
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

        if ($old_ticket['title'] != $new_ticket['title']) {
            $contr->add_to_ticket_history($ticket_id, "TitleChange", $old_ticket['title'], $new_ticket['title']);
            $changes = True;
        }
        if ($old_ticket['project'] != $new_ticket['project']) {
            $contr->add_to_ticket_history($ticket_id, "ProjectChange", $old_ticket['project'], $new_ticket['project']);
            $changes = True;
        }
        if ($old_ticket['priority'] != $new_ticket['priority']) {
            $contr->add_to_ticket_history($ticket_id, "PriorityChange", $old_ticket['priority'], $new_ticket['priority']);
            $changes = True;
        }
        if ($old_ticket['type'] != $new_ticket['type']) {
            $contr->add_to_ticket_history($ticket_id, "TypeChange", $old_ticket['type'], $new_ticket['type']);
            $changes = True;
        }
        if (trim($old_ticket['description']) != trim($new_ticket['description'])) {
            $contr->add_to_ticket_history($ticket_id, "DescriptionChange", $old_ticket['description'], $new_ticket['description']);
            $changes = True;
        }
        if ($old_ticket['status'] != $new_ticket['status']) {
            $contr->add_to_ticket_history($ticket_id, "StatusChange", $old_ticket['status'], $new_ticket['status']);
            $changes = True;
        }
        if ($old_ticket['developer_assigned'] != $new_ticket['developer_assigned']) {
            $contr->add_to_ticket_history($ticket_id, "AssignedTo", $old_ticket['developer_assigned'], $new_ticket['developer_assigned']);
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

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
