<?php
    require 'templates/ui_frame.php';

    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        exit(); 
    }
    if(!($_GET['id'])){
        header('Location: show_projects.php');
        exit();
    }


    //Only admins will see the following

    include('includes/db_connect.inc.php');
    $project_id = $_GET['id'];

    // write query for all projects
    $sql = "SELECT * FROM projects WHERE id = '$project_id' ";

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an associative array
    $project = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    ?>
    <div class="main">

    <h2>Project: <?php echo $project['project_name']?></h2>

    <table style="width:100%">
        <tr>
            <th>project_id</th>
            <th>project name</th>
            <th>description</th>
            <th>created by</th>
            <th>created_at</th>
        </tr>

        <tr>   
            <td><?php echo $project['id']?></td>
            <td><?php echo $project['project_name']?></td>
            <td><?php echo $project['project_description']?></td>
            <td><?php echo $project['created_by']?></td> 
            <td><?php echo $project['created_at']?></td>    
        </tr>
    </table>
   
   <?php
    // free result from memory (good practice)
    mysqli_free_result($result);
    ?>


    <h2>Assigned personnel: </h2>

    <?php
    // write query for all projects
    //This can be done in many different ways: https://stackoverflow.com/questions/7364969/how-to-filter-sql-results-in-a-has-many-through-relation
    $sql = "SELECT *
            FROM users
            JOIN project_enrollments
            USING (user_id)
            WHERE project_enrollments.project_id = $project_id";
    
    //I understand this better: 
    $sql2 = "SELECT * 
             FROM users
             WHERE users.user_id IN (SELECT user_id FROM project_enrollments WHERE project_id = $project_id)";


    // make query and get result
    $result = mysqli_query($conn, $sql2);

    // fetch the resulting rows as an associative array
    $enrollments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <table style="width:20%">
        <tr>
            <th>username</th>
            <th>email</th>
            <th>role</th>

        </tr>
    
    <?php foreach($enrollments as $enrollment): ?>         
        <tr>   
            <td><?php echo $enrollment['username']?></td>
            <td><?php echo $enrollment['email']?></td>
            <td><?php echo $role_str[$enrollment['role']]?></td>
            <td>
                <form action="includes/end_project_enrollment.inc.php" method="POST">     
                <input type="hidden" name="user_id" value="<?php echo $enrollment['user_id']?>"> 
                <input type="hidden" name="project_id" value="<?php echo $project_id?>">                                 
                <input type="submit" value="Un-assign" name="unassign_from_project_submit">
                </form>
            </td>        

        </tr>
    <?php endforeach;?>
    </table>

   
    <h2>Delete project</h2>

    <form action="includes/delete_project.inc.php" method="POST">
        <input type="hidden" name="delete_project_w_id" value="<?php echo $project_id ?>">
        <input type="submit" name="delete_project_submit" value="Delete project">
    </form>
        
   
    <h2>Add staff to this project: </h2>
    <p>Search persons: _____</p>
    <?php
    //selecct users not already enrolled in this project
    $sql3 = "SELECT * 
            FROM users
            WHERE users.user_id NOT IN (SELECT user_id FROM project_enrollments WHERE project_id = $project_id)";
    
    // make query and get result
    $result = mysqli_query($conn, $sql3);

    // fetch the resulting rows as an associative array
    $not_enrolled_users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <nav>
        <ul>
            <?php foreach($not_enrolled_users as $user): ?>             
            <li>
                <?php echo $user['username'] ?>
                <form style="display:inline"  action="includes/assign_to_project.inc.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input  type="submit" value="Assign to project" name="assign_user_submit">
                </form>
            </li>
            <?php endforeach;?>
        </ul>
    </nav>

    
    <h2>Tickets for this project: </h2>
    <p>Search tickets: _____</p>
    <?php
    //select tickets for this project
    // 
    $sql = "SELECT * 
            FROM tickets
            WHERE tickets.project_id = $project_id";
    
    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an associative array
    $tickets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <table>
        <tr>
            <th>Ticket Title</th>
            <th>Priority</th>
            <th>Status</th>
        </tr>

        <?php foreach($tickets as $ticket): ?>        
        <tr>
            <td><?php echo $ticket['title']?> </td>
            <td><?php echo $priority_str[$ticket['priority']]?> </td>
            <td><?php echo $ticket_status_str[$ticket['status']]?> </td>

            <!-- show details button -->
            <td>
                <form style="display:inline"  action="show_ticket_details.php" method="GET">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                    <input type="hidden" name="project_name" value="<?php echo $project['project_name'];?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id?>">
                    <input  type="submit" value="Details" name="show_ticket_details_submit">
                </form>
            </td>
    <?php endforeach;?>
    
    </table>


    <h2>Add ticket to project: </h2>
    <form action="add_ticket.php?>" method="GET">
    <input type=hidden name = "project_id" value= "<?php echo $project_id ?>">
    <input type=hidden name = "project_name" value= "<?php echo $project['project_name'] ?>">
    <input type="submit" value="Add ticket" name="add_ticket_submit">
    </form> 

<?php
    // close connection
    mysqli_close($conn);
    ?>

    <?php
    // free result from memory (good practice)
    mysqli_free_result($result);
    ?>

<?php
    require 'templates/footer.php';
?>