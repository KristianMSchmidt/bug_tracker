<?php
include_once('../classes/form_handlers/TicketValidator.class.php');
include_once('../includes/shared/auto_loader.inc.php');


class EditTicketHandler extends TicketValidator
{
    protected $ticket_id;

    public function __construct($post_data)
    {
        $this->new_ticket = $post_data;
        $this->ticket_id = $post_data['ticket_id'];
        $this->contr = new Controller();
        $this->old_ticket = $this->contr->get_ticket_by_id($this->ticket_id);
    }

    public function process_input()
    {
        session_start();

        $this->validate_title_and_description();

        if (!$this->errors) {
            $this->validate_title_unique('edit');
        }
        if (!$this->errors) {
            $this->attempt_edit();
        }

        if (!$this->errors) {
            $_SESSION['edit_ticket_succes'] = true;
            header("location:../views/ticket_details.php?ticket_id={$this->ticket_id}");
            exit();
        } else {
            $_SESSION['errors'] = $this->errors;
            $_SESSION['data'] = $this->new_ticket;
            $_SESSION['data']['project_name'] = $this->contr->get_project_name_by_id($this->new_ticket['project_id'])['project_name'];
            $_SESSION['data']['ticket_priority_name'] = $this->contr->get_priority_name_by_id($this->new_ticket['priority_id'])['ticket_priority_name'];
            $_SESSION['data']['ticket_type_name'] = $this->contr->get_ticket_type_name_by_id($this->new_ticket['type_id'])['ticket_type_name'];
            $_SESSION['data']['ticket_status_name'] = $this->contr->get_ticket_status_name_by_id($this->new_ticket['status_id'])['ticket_status_name'];
            $_SESSION['data']['developer_name'] = $this->contr->get_user_by_id($this->new_ticket['developer_assigned'])['full_name'];
            header('location:../views/edit_ticket.php');
            exit();
        }
    }

    private function attempt_edit()
    {
        $old_ticket = $this->old_ticket;
        $new_ticket = $this->new_ticket;
        $ticket_id = $this->ticket_id;
        $contr = $this->contr;

        $changes = False;

        if ($old_ticket['title'] !== trim($new_ticket['title'])) {
            $contr->add_to_ticket_history($ticket_id, "TitleChange", $old_ticket['title'], $new_ticket['title']);
            $changes = True;
        }
        if ($old_ticket['description'] !== trim($new_ticket['description'])) {
            $contr->add_to_ticket_history($ticket_id, "DescriptionChange", $old_ticket['description'], $new_ticket['description']);
            $changes = True;
        }

        if ($old_ticket['project_id'] !== $new_ticket['project_id']) {
            $contr->add_to_ticket_history($ticket_id, "ProjectChange", $old_ticket['project_name'], $new_ticket['project_name']);
            $changes = True;
        }

        if ($old_ticket['priority_id'] !== $new_ticket['priority_id']) {
            $contr->add_to_ticket_history($ticket_id, "PriorityChange", $old_ticket['ticket_priority_name'], $new_ticket['ticket_priority_name']);
            $changes = True;
        }
        if ($old_ticket['type_id'] !== $new_ticket['type_id']) {
            $contr->add_to_ticket_history($ticket_id, "TypeChange", $old_ticket['ticket_type_name'], $new_ticket['ticket_type_name']);
        }

        if ($old_ticket['status_id'] !== $new_ticket['status_id']) {
            $contr->add_to_ticket_history($ticket_id, "StatusChange", $old_ticket['ticket_status_name'], $new_ticket['ticket_status_name']);
            $changes = True;
        }

        if ($old_ticket['developer_assigned'] !== $new_ticket['developer_assigned']) {
            $developer_is_enrolled_in_project = $contr->check_project_enrollment($new_ticket['project_id'], $new_ticket['developer_assigned']);
            if (!$developer_is_enrolled_in_project) {
                $contr->assign_to_project($new_ticket['developer_assigned'], $new_ticket['project_id']);
                $message = "enrolled you in the project '{$new_ticket['project_name']}'";
                $contr->create_notification(4, $new_ticket['developer_assigned'], $message, $_SESSION['user_id']);
            }
            $contr->add_to_ticket_history($ticket_id, "AssignedTo", $old_ticket['developer_name'], $new_ticket['developer_name']);
            $message = "assigned you to the ticket '{$new_ticket['title']}'";
            $contr->create_notification(2, $new_ticket['developer_assigned'], $message, $_SESSION['user_id']);
            $message = "unassigned you from the ticket '{$old_ticket['title']}'";
            $contr->create_notification(3, $old_ticket['developer_assigned'], $message, $_SESSION['user_id']);
            $changes = True;
        }

        if (!$changes) {
            $this->add_error('no_changes_error', 'No changes made to ticket');
        } else {
            $contr->update_ticket($new_ticket);
        }
    }
}
