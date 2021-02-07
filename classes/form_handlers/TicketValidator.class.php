<?php
include_once('../classes/form_handlers/TicketAndProjectValidator.class.php');

class TicketValidator extends TicketAndProjectValidator
{
    protected $new_ticket;
    protected $old_ticket;
    protected $errors = [];
    protected $contr;

    public function __construct($post_data)
    {
        $this->new_ticket = $post_data['new_ticket'];
        if (isset($post_data['old_ticket'])) {
            $this->old_ticket = $post_data['old_ticket'];
        }
    }

    protected function validate_title_unique($type)
    {
        $title = trim($this->new_ticket['title']);
        include_once('../includes/auto_loader.inc.php');
        $contr = new Controller();
        $this->contr = $contr;
        $title = $contr->get_ticket_by_title($title, $this->new_ticket['project_id']);
        if ($title) {
            if ($type == 'create' || ($type == 'edit' && ($title['title'] !== $this->new_ticket['title']))) {
                $this->add_error('title', 'The selected project already has a ticket by that name');
            }
        }
    }

    protected function validate_title_and_description()
    {
        $this->validate_title_length($this->new_ticket['title'], 'Ticket');
        $this->validate_description($this->new_ticket['description'], 'Ticket');
    }
}
