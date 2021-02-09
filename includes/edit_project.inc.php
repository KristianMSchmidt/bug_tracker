<?php
include_once('../includes/shared/post_check.inc.php');
include('../classes/form_handlers/EditProjectHandler.class.php');
$edit_project_handler = new EditProjectHandler($_POST);
$edit_project_handler->process_input();
