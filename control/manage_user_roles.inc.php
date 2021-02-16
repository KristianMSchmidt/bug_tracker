<?php
session_start();
require_once('controller.class.php');

$selected_user_ids = json_decode($_POST['user_ids']);
$demo_users = array("Demo Admin", "Demo PM", "Demo Dev", "Demo Sub");

$contr = new Controller();
$chosen_role_name = $contr->get_role_name_by_role_id($_POST['new_role']);

$_SESSION['feedback_users'] = [];

foreach ($selected_user_ids as $user_id) {
    $user = $contr->get_users($user_id)[0];
    $feedback_user = [];
    $feedback_user['full_name'] = $user['full_name'];
    $feedback_user['old_role_name'] = $user['role_name'];

    // only update role, if new role is different than the old:
    if ($user['role_name'] !== $chosen_role_name) {

        // demo users can't have their role changed
        if (!in_array($user['full_name'], $demo_users)) {
            // update role
            $contr->update_role($_POST['new_role'], $_SESSION['user_id'], $user_id);

            $feedback_user['new_role_name'] = $chosen_role_name;
            $feedback_user['message'] = "Yes";
            $feedback_user['color'] = "green";

            // create notification
            $message = "updated your role to '{$chosen_role_name}'";
            $contr->create_notification(1, $user_id, $message, $_SESSION['user_id']);
        } else {
            $feedback_user['new_role_name'] = $feedback_user['old_role_name'];
            $feedback_user['message'] = "No (immutable role)";
            $feedback_user['color'] = "red";
        }
    } else {
        $feedback_user['new_role_name'] =   $feedback_user['old_role_name'];
        $feedback_user['message'] = "No";
        $feedback_user['color'] = "red";
    }
    array_push($_SESSION['feedback_users'], $feedback_user);
}
header("location: ../view/pages/manage_user_roles.php");
exit();
