<?php
if ($_POST) {
    include_once('shared/post_check.inc.php');
    include_once('shared/auto_loader.inc.php');
    $selected_users = json_decode($_POST['user_ids']);
    $contr = new Controller();
    $new_role = $contr->get_role_name_by_role_id($_POST['new_role']);
    foreach ($selected_users as $user_id) {
        $contr->set_role(trim($user_id),  $_POST['new_role']);
        $message = "updated your role to '{$new_role['role_name']}'";
        $contr->create_notification(1, $user_id, $message, $_SESSION['user_id']);
    }
    session_start();
    $_SESSION['selected_users'] = $selected_users;
    $_SESSION['role_change_succes'] = true;
    header("location: ../views/manage_user_roles.php");
    exit();
}
