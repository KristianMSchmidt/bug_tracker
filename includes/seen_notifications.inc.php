<?php
require 'db_connect.inc.php';

// check POST param
if (!isset($_POST['user_id'])) {
    header('Location: ../login.php');
    exit();
}


//resume session
session_start();

// make sql
$sql = "UPDATE notifications SET unseen = 0 WHERE user_id = {$_SESSION['user_id']}";

// make query and get result
$result = mysqli_query($conn, $sql);

// free result from memory and close connection
mysqli_close($conn);

if (!$result) {
    //error message: A database error occured
    echo 'query error: ' . mysqli_error($conn);
    exit();
} else {
    //succes

    header('Location: ../' . $_POST['page_name'] . '?seen=succes');
}
