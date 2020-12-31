<?php 
    require 'db_connect.inc.php';
    session_start();
    
    // check POST param
    if(!isset($_POST['delete_submit'])){
        header('Location: ../login.php');
        exit();
    }
    
	else{
        $user_id = $_POST['delete_member_w_id'];

        
      // make sql to delete member from user-table
      $sql = "DELETE FROM users WHERE user_id = '$user_id'";
        // save to db and check
        if(mysqli_query($conn, $sql)){
            // success
            header('Location: ../show_users.php?delete_member=succes');
        } 
        else {
            echo 'query error: '. mysqli_error($conn);
            exit();
        }
	}

	// free result from memory and close connection
	mysqli_close($conn);
