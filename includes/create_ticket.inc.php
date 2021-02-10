<?php
include('../includes/shared/post_check.inc.php');
include('../classes/form_handlers/CreateTicketHandler.class.php');
session_start();

$create_ticket_handler = new CreateTicketHandler($_POST);
$errors = $create_ticket_handler->create_ticket();

$_SESSION['data'] = $_POST;

if (!$errors) {
    $_SESSION['created_ticket_succes'] = true;
    header("location:../views/project_details.php?project_id={$_POST['project_id']}");
    exit();
} else {
    $_SESSION['errors'] = $errors;
    header("location:../views/create_ticket.php");
    exit();
}
