<?php
require_once('form_handlers/TicketAndProjectValidator.class.php');

class TicketValidator extends TicketAndProjectValidator
{
    protected $new_ticket;
    protected $ticket_id = 'undefined';
    protected $errors = [];
    protected $contr;

    protected function validate_title_and_description()
    {
        $this->validate_title_length($this->new_ticket['title'], 'Ticket');
        $this->validate_description($this->new_ticket['description'], 'Ticket');
    }

    protected function validate_title_unique()
    {
        //check if the selected project already has a ticket with this title
        $other_ticket_same_title_and_same_project = $this->contr->check_ticket_title_unique(trim($this->new_ticket['title']), $this->ticket_id, $this->new_ticket['project_id']);
        if ($other_ticket_same_title_and_same_project) {
            $this->add_error('title', 'The selected project already has a ticket by that name');
        }
    }
}
