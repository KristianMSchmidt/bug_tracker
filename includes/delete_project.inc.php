<?php 
    require 'db_connect.inc.php';
    
    // check POST param
    if(!isset($_POST['delete_project_submit'])){
        header('Location: ../login.php');
        exit();
    }
    
	else{
        $project_id = $_POST['delete_project_w_id'];

        
      // make sql to delete member from user-table
      $sql = "DELETE FROM projects WHERE id = '$project_id'";
        // save to db and check
        if(mysqli_query($conn, $sql)){
            // success
            header('Location: ../show_projects.php?delete_project=succes');
        } 
        else {
            echo 'query error: '. mysqli_error($conn);
            exit();
        }
	}

	// free result from memory and close connection
	mysqli_close($conn);
?>  
