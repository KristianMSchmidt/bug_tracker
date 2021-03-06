<?php
require_once('form_handlers/CreateProjectHandler.class.php');
require_once('controller.class.php');
session_start();

$create_project_handler = new CreateProjectHandler($_POST);
$errors = $create_project_handler->create_project();

$_SESSION['data'] = $_POST;

if ($errors) {
    $_SESSION['errors'] = $errors;
    header('location:../view/pages/create_project.php');
    exit();
} else {
    $_SESSION['create_project_succes'] = true; //husk at ændre placeringen af denne
    $contr = new Controller();
    $project_id = $contr->check_project_name_unique(trim($_POST['project_name']), -1)['id'];
    $contr->assign_to_project($_SESSION['user_id'], $project_id);
    header("location:../view/pages/project_details.php?project_id={$project_id}");
    exit();
}
