<?php
session_start();

if (!isset($_POST['create_project_submit'])) {
    header('location: ../login.php');
    exit(); //make sure that code below does not get executed when we redirect
}

require "db_connect.inc.php";
$project_title = $_POST['title'];
$project_description = $_POST['description'];


if (empty($project_title)) {
    //error message: Fill in title field
    header("Location: ../create_project.php?error=notitle&title=&description={$project_description}");
    exit();
}

if (empty($project_description)) {
    //error message: Fill in description field
    header("Location: ../create_project.php?error=nodescription&title={$project_title}&description=");
    exit();
} else {

    // escape sql chars
    $project_title = mysqli_real_escape_string($conn, $project_title);
    $project_description = mysqli_real_escape_string($conn, $project_description);
    $created_by = $_SESSION['user_id'];

    // create sql    
    $sql = "INSERT INTO projects(project_name, project_description, created_by) VALUES('$project_title','$project_description', '$created_by')";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header("Location: ../create_project.php?createprojectsucces");
        exit();
    } else {
        //database error
        if (strpos(mysqli_error($conn), 'Duplicate entry') !== false) {
            header("Location: ../create_project.php?error=titleexists&title={$project_title}&description={$project_description}");
            exit();
        } else {
            echo ('query error: ' . mysqli_error($conn));
            exit();
        }
    }
}
// free result from memory (good practice) and close connection
mysqli_free_result($result);
mysqli_close($conn);
