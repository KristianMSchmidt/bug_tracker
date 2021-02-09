<?php
include_once('../includes/shared/post_check.inc.php');
include('../classes/form_handlers/CreateProjectHandler.class.php');
$create_project_handler = new CreateProjectHandler($_POST);
$create_project_handler->process_input();
