<?php
require_once('controller.class.php');
session_start();
$contr = new Controller();

$selected_users = json_decode($_POST['user_ids']);
$project_name = $contr->get_project_name_by_id($_POST['project_id']);
$_SESSION['selected_users'] = $selected_users;

if (isset($_POST['enroll_users_submit'])) {
    $notification_message = "enrolled you in the project '{$project_name}'";
    foreach ($selected_users as $user_id) {
        $contr->assign_to_project($user_id, $_POST['project_id']);
        $contr->create_notification(4, $user_id, $notification_message, $_SESSION['user_id']);
    }
    $_SESSION['enroll_users_succes'] = true;
}

if (isset($_POST['disenroll_users_submit'])) {
    $notification_message = "disenrolled your from the project '{$project_name}'";
    foreach ($selected_users as $user_id) {
        $contr->unassign_from_project($user_id, $_POST['project_id']);
        $contr->create_notification(5, $user_id, $notification_message, $_SESSION['user_id']);
    }
    $_SESSION['disenroll_users_succes'] = true;
}

header("location: ../view/manage_project_users.php?project_id={$_POST['project_id']}");
exit();
