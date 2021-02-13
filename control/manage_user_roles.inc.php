<?php
require('shared/post_check.inc.php');
require_once('controller.class.php');
session_start();

$selected_users = json_decode($_POST['user_ids']);
$contr = new Controller();
$new_role_name = $contr->get_role_name_by_role_id($_POST['new_role']);

$updated_users = [];

foreach ($selected_users as $user_id) {

    $selected_user = $contr->get_users($user_id)[0];

    //Only update role, if new role is different than the old:
    if ($selected_user['role_name'] !== $new_role_name) {

        //update role
        $contr->update_role($_POST['new_role'], $_SESSION['user_id'], $user_id);

        array_push($updated_users, $selected_user);

        //create notification
        $message = "updated your role to '{$new_role_name}'";
        $contr->create_notification(1, $user_id, $message, $_SESSION['user_id']);
    } else {
        echo "SAME ROLE";
    }

    $_SESSION['updated_users'] = $updated_users;
}
$_SESSION['role_change_succes'] = true;
$_SESSION['new_role_name'] = $new_role_name;

header("location: ../views/manage_user_roles.php");
exit();
