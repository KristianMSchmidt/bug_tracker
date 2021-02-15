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
        if (!isset($this->new_ticket['developer_assigned'])) {
            $this->add_error('developer', 'Choose developer');
        }
    }

    private function create()
    {
        $this->contr->create_ticket($this->new_ticket);
        $developer_is_enrolled_in_project = $this->contr->check_project_enrollment($this->new_ticket['project_id'], $this->new_ticket['developer_assigned']);
        if (!$developer_is_enrolled_in_project) {
            echo "Error: Developer is not enrolled in project";
            exit();
        }
        $message = "assigned you to the ticket '{$this->new_ticket['title']}'";
        $this->contr->create_notification(2, $this->new_ticket['developer_assigned'], $message, $this->new_ticket['submitter']);
    }
}
