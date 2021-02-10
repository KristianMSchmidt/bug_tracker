<?php
include_once('shared/post_check.inc.php');
include_once('form_handlers/EditTicketHandler.class.php');
include_once('controller.class.php');

session_start();

$edit_ticket_handler = new EditTicketHandler($_POST);
$errors = $edit_ticket_handler->edit_ticket();

if (!$errors) {
    $_SESSION['edit_ticket_succes'] = true;
    header("location:../views/ticket_details.php?ticket_id={$_POST['ticket_id']}");
    exit();
} else {
    $contr = new Controller();
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $_POST;
    $_SESSION['data']['project_name'] = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];
    $_SESSION['data']['ticket_priority_name'] = $contr->get_priority_name_by_id($_POST['priority_id'])['ticket_priority_name'];
    $_SESSION['data']['ticket_type_name'] = $contr->get_ticket_type_name_by_id($_POST['type_id'])['ticket_type_name'];
    $_SESSION['data']['ticket_status_name'] = $contr->get_ticket_status_name_by_id($_POST['status_id'])['ticket_status_name'];
    $_SESSION['data']['developer_name'] = $contr->get_user_by_id($_POST['developer_assigned'])['full_name'];
    header('location:../views/edit_ticket.php');
    exit();
}
