<?php
include('../classes/form_handlers/CreateTicketHandler.class.php');
$create_ticket_handler = new CreateTicketHandler(array('new_ticket' => $_POST));
$create_ticket_handler->process_input();
