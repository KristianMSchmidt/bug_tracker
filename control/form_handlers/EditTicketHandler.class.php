<?php
require_once('form_handlers/TicketValidator.class.php');

class EditTicketHandler extends TicketValidator
{
    protected $ticket_id;
    protected $user_id;

    public function __construct($new_ticket, $contr, $user_id)
    {
        $this->new_ticket = $new_ticket;
        $this->ticket_id = $new_ticket['ticket_id'];
        $this->contr = $contr;
        $this->old_ticket = $this->contr->get_ticket_by_id($this->ticket_id);
        $this->user_id = $user_id;
    }

    public function edit_ticket()
    {
        $this->validate_title_and_description();

        if (!$this->errors) {
            $this->validate_title_unique('edit');
        }
        if (!$this->errors) {
            $this->attempt_edit();
        }
        return $this->errors;
    }

    private function attempt_edit()
    {
        $old_ticket = $this->old_ticket;
        $new_ticket = $this->new_ticket;
        $ticket_id = $this->ticket_id;
        $contr = $this->contr;

        $changes = False;


        if ($old_ticket['title'] !== trim($new_ticket['title'])) {
            $contr->add_to_ticket_events($ticket_id, 1, $old_ticket['title'], $new_ticket['title']);
            $changes = True;
        }
        if ($old_ticket['description'] !== trim($new_ticket['description'])) {
            $contr->add_to_ticket_events($ticket_id, 2, $old_ticket['description'], $new_ticket['description']);
            $changes = True;
        }

        if ($old_ticket['priority_id'] !== $new_ticket['priority_id']) {
            $contr->add_to_ticket_events($ticket_id, 3, $old_ticket['ticket_priority_name'], $new_ticket['ticket_priority_name']);
            $changes = True;
        }
        if ($old_ticket['type_id'] !== $new_ticket['type_id']) {
            $contr->add_to_ticket_events($ticket_id, 4, $old_ticket['ticket_type_name'], $new_ticket['ticket_type_name']);
            $changes = True;
        }

        if ($old_ticket['status_id'] !== $new_ticket['status_id']) {
            $contr->add_to_ticket_events($ticket_id, 5, $old_ticket['ticket_status_name'], $new_ticket['ticket_status_name']);
            $changes = True;
        }

        if ($old_ticket['developer_assigned_id'] !== $new_ticket['developer_assigned_id']) {
            $developer_is_enrolled_in_project = $contr->get_enrollment_start_by_user_and_project($new_ticket['project_id'], $new_ticket['developer_assigned_id']);
            if (!$developer_is_enrolled_in_project) {
                echo "Error: The chosen developer is not enrolled in project";
                exit();
            }
            $contr->add_to_ticket_events($ticket_id, 6, $old_ticket['developer_name'], $new_ticket['developer_name']);
            $notification_type_id = 2; //notifify new developer assigned to ticket
            $contr->create_notification($notification_type_id, $this->ticket_id,  $new_ticket['developer_assigned_id'], $this->user_id);
            $notification_type_id = 3; //notifify old developer un-assigned from ticket
            $contr->create_notification($notification_type_id, $this->ticket_id, $old_ticket['developer_assigned_id'], $this->user_id);
            $changes = True;
        }

        if (!$changes) {
            $this->add_error('no_changes_error', 'No changes made to ticket');
        } else {
            $contr->update_ticket($new_ticket);
        }
    }
}
