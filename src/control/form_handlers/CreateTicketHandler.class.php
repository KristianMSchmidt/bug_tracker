<?php
require_once('form_handlers/TicketValidator.class.php');
require_once('controller.class.php');

class CreateTicketHandler extends TicketValidator
{
    public function __construct($post_data)
    {
        $this->new_ticket = $post_data;
        $this->contr = new Controller();
    }
    public function create_ticket()
    {
        $this->validate_title_and_description();
        $this->validate_other();

        if (!$this->errors) {
            $this->validate_title_unique('create');
        }
        if (!$this->errors) {
            $this->create();
        }
        return $this->errors;
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
        if (!isset($this->new_ticket['developer_assigned_id'])) {
            $this->add_error('developer', 'Choose developer');
        }
    }

    private function create()
    {
        $this->contr->create_ticket($this->new_ticket);
        $notification_type_id = 2; // you got assigned to ticket
        $ticket_id = $this->contr->get_ticket_id_by_title_and_project($this->new_ticket['title'], $this->new_ticket['project_id']);
        $this->contr->create_notification($notification_type_id, $ticket_id, $this->new_ticket['developer_assigned_id'], $this->new_ticket['submitter_id']);
    }
}
