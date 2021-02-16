<?php
require_once('form_handlers/EditTicketHandler.class.php');
require_once('controller.class.php');
session_start();

$contr = new Controller();
$new_ticket = $_POST;
$new_ticket['ticket_priority_name'] = $contr->get_priority_name_by_id($_POST['priority_id'])['ticket_priority_name'];
$new_ticket['ticket_type_name'] = $contr->get_ticket_type_name_by_id($_POST['type_id'])['ticket_type_name'];
$new_ticket['ticket_status_name'] = $contr->get_ticket_status_name_by_id($_POST['status_id'])['ticket_status_name'];
$new_ticket['developer_name'] = $contr->get_users($_POST['developer_assigned'])[0]['full_name'];

$edit_ticket_handler = new EditTicketHandler($new_ticket, $contr, $_SESSION['user_id']);
$errors = $edit_ticket_handler->edit_ticket();

if (!$errors) {
    $_SESSION['edit_ticket_succes'] = true;
    header("location:../view/ticket_details.php?ticket_id={$_POST['ticket_id']}");
    exit();
} else {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $new_ticket;
    header('location:../view/edit_ticket.php');
}
