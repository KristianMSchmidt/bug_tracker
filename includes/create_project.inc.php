<?php
include('../includes/shared/post_check.inc.php');
include('../classes/form_handlers/CreateProjectHandler.class.php');
session_start();

$create_project_handler = new CreateProjectHandler($_POST);
$errors = $create_project_handler->create_project();

$_SESSION['data'] = $_POST;

if ($errors) {
    $_SESSION['errors'] = $errors;
    header('location:../views/create_project.php');
    exit();
} else {
    $_SESSION['create_project_succes'] = true;
    header('location:../views/my_projects.php');
    exit();
}
