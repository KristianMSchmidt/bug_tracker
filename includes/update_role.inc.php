<?php
require 'db_connect.inc.php';

// check POST param
if (!isset($_POST['update_role'])) {
    header('Location: ../login.php');
    exit();
} else {
    session_start();

    $username = key($_POST);  //first key in array
    $new_role = $_POST[key($_POST)];
    echo $new_role;

    // escape sql chars
    $admin_id = $_SESSION['user_id'];

    // make sql
    $sql = "UPDATE users SET role = '$new_role', updated_at = NOW(), updated_by='$admin_id'
                WHERE username = '$username'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: ../show_users.php?update_role=succes');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}

// free result from memory and close connection
mysqli_close($conn);
