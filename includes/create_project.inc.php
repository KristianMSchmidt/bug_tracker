<?php
include_once('../includes/post_check.inc.php');
include_once('../includes/auto_loader.inc.php');
session_start();
$contr = new Controller();

include('../classes/form_handlers/CreateProjectHandler.class.php');
$create_project_handler = new CreateProjectHandler($_POST);
$create_project_handler->process_input();
