<?php
require_once('form_handlers/CreateProjectHandler.class.php');
require_once('controller.class.php');
session_start();

$create_project_handler = new CreateProjectHandler($_POST);
$errors = $create_project_handler->create_project();

$_SESSION['data'] = $_POST;

if ($errors) {
    $_SESSION['errors'] = $errors;
    header('location:../view/create_project.php');
    exit();
} else {
    $_SESSION['create_project_succes'] = true;
    header('location:../view/my_projects.php');
    exit();
}
