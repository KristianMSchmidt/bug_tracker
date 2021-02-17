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

    // only update role, if new role is different than the old:
    if ($user['role_name'] !== $chosen_role_name) {

        // demo users can't have their role changed
        if (!in_array($user['full_name'], $demo_users)) {
            // update role
            $contr->update_role($_POST['new_role'], $_SESSION['user_id'], $user_id);
            $new_role_name = $chosen_role_name;
            $message = "Yes";
            $color = "green";

            // create notification
            $notification_type_id = 1; // role update
            $contr->create_notification($notification_type_id, $_POST['new_role'], $user_id, $_SESSION['user_id']);
        } else {
            $new_role_name = $user['role_name'];
            $message = "No (immutable role)";
            $color = "red";
        }
    } else {
        $new_role_name = $user['role_name'];
        $message = "No";
        $color = "red";
    }
    $feedback_user = array(
        'full_name' => $user['full_name'],
        'old_role_name' => $user['role_name'],
        'new_role_name' => $new_role_name,
        'message' => $message,
        'color' => $color
    );
    array_push($_SESSION['feedback_users'], $feedback_user);
}
header("location: ../view/pages/manage_user_roles.php");
exit();
