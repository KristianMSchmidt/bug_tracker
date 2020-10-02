<?php 
    require 'db_connect.inc.php';
    print_r($_POST);
    
    // check POST param
    if(!isset($_POST['delete_ticket_submit'])){
        header('Location: ../login.php');
        exit();
    }
    
	else{
        $ticket_id = $_POST['ticket_id'];

        
      // make sql to delete member from user-table
      $sql = "DELETE FROM tickets WHERE ticket_id = '$ticket_id'";
        // save to db and check
        if(mysqli_query($conn, $sql)){
            // success
            header('Location: ../show_tickets.php?delete_ticket=succes');
        } 
        else {
            echo 'query error: '. mysqli_error($conn);
            exit();
        }
	}

	// free result from memory and close connection
	mysqli_close($conn);
?>  


