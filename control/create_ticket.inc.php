<?php
require_once('form_handlers/CreateTicketHandler.class.php');
session_start();

$create_ticket_handler = new CreateTicketHandler($_POST);
$errors = $create_ticket_handler->create_ticket();
$_SESSION['data'] = $_POST;

if (!$errors) {
    $_SESSION['created_ticket_succes'] = true;
    header("location:../view/pages/project_details.php?project_id={$_POST['project_id']}");
    exit();
} else {
    $_SESSION['errors'] = $errors;
    $params = "project_id={$_POST['project_id']}&project_options={$_POST['project_options']}&search={$_POST['search_input']}";
    header("location:../view/pages/create_ticket.php?" . $params);
    exit();
}
