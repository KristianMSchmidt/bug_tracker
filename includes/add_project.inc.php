<?php

if(!isset($_POST['add_project_submit'])){
    header('location: ../login.php');
    exit();//make sure that code below does not get executed when we redirect
}

require "db_connect.inc.php";

session_start();
$project_title = $_POST['title'];
$project_descriptiton = $_POST['description'];

if(empty($project_title)){
    //error message: Fill in title fields
    header("Location: ../add_project.php?error=notitle");
    exit();
}

else{
   
    // escape sql chars
    $project_title = mysqli_real_escape_string($conn, $project_title);
    $project_description = mysqli_real_escape_string($conn, $project_descriptiton);
    $created_by = $_SESSION['user_id'];
   
    // create sql    
    $sql = "INSERT INTO projects(name, description, created_by) VALUES('$project_title','$project_description', '$created_by')";

    // save to db and check
    if(mysqli_query($conn, $sql)){

        // success
        header("Location: ../show_projects.php?addproject=succes");
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