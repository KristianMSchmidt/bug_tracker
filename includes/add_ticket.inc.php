<?php
require 'tools.inc.php';
session_start();

if(!isset($_POST["add_ticket_submit"])){
    header('location: ../dashboard.php');
    exit();
}

require "db_connect.inc.php";

$ticket_title = $_POST['title'];
$ticket_descriptiton = $_POST['description'];
$project_id = $_POST['project_id'];
$project_name = $_POST['project_name'];
$priority = $_POST['ticket_priority'];
$status = $_POST['ticket_status'];
$type = $_POST['ticket_type'];
$submitter = $_SESSION['user_id'];

if(empty($ticket_title)){
    //error message: Fill in title fields
    header("Location: ../add_ticket.php?error=notitle&project_id={$project_id}&project_name={$project_name}");
    exit();
}

else{
   
    // escape sql chars
    $ticket_title = mysqli_real_escape_string($conn, $ticket_title);
    $ticket_description = mysqli_real_escape_string($conn, $ticket_descriptiton);
   
    // create sql    

    $sql = "INSERT INTO tickets(title, ticket_description, priority, ticket_type, status, submitter, project_id) 
            VALUES('$ticket_title','$ticket_description', '$priority', '$status', '$type', '$submitter', '$project_id')";

    // save to db and check
    if(mysqli_query($conn, $sql)){

        // success
        header("Location: ../show_project_details.php?id={$project_id}&addticket=succes");
        exit();
    } 
    else{
        //database error
        echo('query error: '. mysqli_error($conn));
        exit();
    }
}

// free result from memory (good practice)
mysqli_free_result($result);

// close connection
mysqli_close($conn);