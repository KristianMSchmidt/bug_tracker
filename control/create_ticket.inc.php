<?php
require('shared/post_check.inc.php');
require_once('form_handlers/CreateTicketHandler.class.php');
session_start();

$create_ticket_handler = new CreateTicketHandler($_POST);
$errors = $create_ticket_handler->create_ticket();

$_SESSION['data'] = $_POST;

if (!$errors) {
    $_SESSION['created_ticket_succes'] = true;
    header("location:../view/project_details.php?project_id={$_POST['project_id']}");
    exit();
} else {
    $_SESSION['errors'] = $errors;
    header("location:../view/create_ticket.php");
    exit();
}
