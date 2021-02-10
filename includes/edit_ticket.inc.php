<?php
include_once('../includes/shared/post_check.inc.php');
include('../classes/form_handlers/EditTicketHandler.class.php');
$edit_ticket_handler = new EditTicketHandler($_POST);
$edit_ticket_handler->process_input();
