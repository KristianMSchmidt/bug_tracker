<?php
require_once('controller.class.php');
session_start();

$contr = new Controller();
$selected_users = json_decode($_POST['user_ids']);
$project_name = $contr->get_project_name_by_id($_POST['project_id']);
$_SESSION['selected_users'] = $selected_users;

if (isset($_POST['enroll_users_submit'])) {
    foreach ($selected_users as $user_id) {
        $contr->assign_to_project($user_id, $_POST['project_id']);
        $notification_type_id = 4; //enroll in project
        $contr->create_notification($notification_type_id, $_POST['project_id'], $user_id, $_SESSION['user_id']);
    }
    $_SESSION['enroll_users_succes'] = true;
}

if (isset($_POST['disenroll_users_submit'])) {
    foreach ($selected_users as $user_id) {
        $contr->unassign_from_project($user_id, $_POST['project_id']);
        $notification_type_id = 5; // disenroll from project
        $contr->create_notification($notification_type_id, $_POST['project_id'], $user_id, $_SESSION['user_id']);
    }
    $_SESSION['disenroll_users_succes'] = true;
}

header("location: ../view/pages/manage_project_users.php?project_id={$_POST['project_id']}");
exit();
