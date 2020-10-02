<?php

if(!isset($_POST['assign_dev_submit'])){
    header('location: ../login.php');
    exit();//make sure that code below does not get executed when we redirect
}

require "db_connect.inc.php";

$ticket_id = $_POST['ticket_id'];
$project_name= $_POST['project_name'];
$project_id=$_POST['project_id'];
$dev = $_POST['developer'];

// create sql    
//$sql = "INSERT INTO tickets(developer_assigned, updated_at) VALUES($developer, NOW()) WHERE ticket_id={$ticket_id}";
$sql = "UPDATE tickets SET developer_assigned = '$dev', updated_at = NOW() WHERE ticket_id = '$ticket_id'"; 

// save to db and check
if(mysqli_query($conn, $sql)){

    // success

    header("Location: ../show_ticket_details.php?ticket_id={$ticket_id}&project_name={$project_name}&project_id={$project_id}");
    exit();
} 
else{
    //database error
    echo('query error: '. mysqli_error($conn));
    exit();
}


// free result from memory (good practice)
mysqli_free_result($result);

// close connection
mysqli_close($conn);