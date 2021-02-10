<?php
include_once('form_handlers/TicketAndProjectValidator.class.php');

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
        $potential_other_ticket = $this->contr->get_ticket_by_title(trim($this->new_ticket['title']));

        if ($potential_other_ticket) {
        }
        if ($potential_other_ticket) {
            if (($potential_other_ticket['ticket_id'] !== $this->ticket_id) && ($potential_other_ticket['project'] == $this->new_ticket['project_id'])) {
                $this->add_error('title', 'The selected project already has a ticket by that name');
            }
        }
    }
}
