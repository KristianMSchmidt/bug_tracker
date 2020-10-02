<?php

if(!isset($_POST['assign_user_submit'])){
    header('location: ../login.php');
    exit();//make sure that code below does not get executed when we redirect
}

require "db_connect.inc.php";

$project_id = $_POST['project_id'];
$user_id = $_POST['user_id'];
   
// create sql    
$sql = "INSERT INTO project_enrollments(user_id, project_id) VALUES('$user_id','$project_id')";

// save to db and check
if(mysqli_query($conn, $sql)){

    // success
    header("Location: ../show_project_details.php?id= $project_id");
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