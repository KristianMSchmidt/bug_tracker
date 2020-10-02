<?php 
    require 'db_connect.inc.php';

    // check POST param
    if(!isset($_POST['unassign_from_project_submit'])){
        header('Location: ../login.php');
        exit();
    }
    
	else{
        $user_id = $_POST['user_id'];
        $project_id = $_POST['project_id'];
        
        
      // make sql to delete member from user-table
      $sql = "DELETE FROM project_enrollments WHERE user_id = '$user_id'";
        // save to db and check
        if(mysqli_query($conn, $sql)){
            // success
            header("Location: ../show_project_details.php?id={$project_id}");
        } 
        else {
            echo 'query error: '. mysqli_error($conn);
            exit();
        }


	}

	// free result from memory and close connection
	mysqli_close($conn);
?>  
