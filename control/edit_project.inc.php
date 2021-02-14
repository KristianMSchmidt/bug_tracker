<?php
require('shared/post_check.inc.php');
require_once('form_handlers/EditProjectHandler.class.php');
session_start();

$edit_project_handler = new EditProjectHandler($_POST);
$errors = $edit_project_handler->edit_project();

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $_POST;
    header('location:../view/edit_project.php');
    exit();
} else {
    $_SESSION['edit_project_succes'] = true;
    header("location:../view/project_details.php?project_id={$_POST['project_id']}");
    exit();
}