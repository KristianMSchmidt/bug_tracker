<?php
require 'templates/ui_frame.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('includes/db_connect.inc.php');

$ticket_id = $_GET['ticket_id'];
$project_name = $_GET['project_name'];
$project_id = $_GET['project_id'];

// write query for ticket
$sql = "SELECT title as ticket_title, 
                description as ticket_description, 
                tickets.created_at, 
                username as assigned_developer, 
                priority, 
                ticket_priority_name, 
                ticket_status_name
        FROM tickets 
        JOIN users
        ON tickets.developer_assigned = users.user_id
        JOIN ticket_priorities
        ON tickets.priority = ticket_priorities.ticket_priority_id
        JOIN ticket_status_types
        ON tickets.status = ticket_status_types.ticket_status_id
        WHERE ticket_id = {$_GET['ticket_id']}";

// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$ticket = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];

?>
<div class="main">
    <h2>Details for ticket # <?php echo $ticket['ticket_id'] ?>:</h2>

    <table style="width:100%">
        <tr>
            <th>ticket title</th>
            <th>description</th>
            <th>project name</th>
            <th>assigned developer</th>
            <th>ticket status</th>
            <th>ticket type</th>
            <th>ticket priority</th>
            <th>submitter</th>
            <th>created_at</th>
        </tr>

        <tr>
            <td><?php echo $ticket['ticket_title']; ?></td>
            <td><?php echo $ticket['ticket_description']; ?></td>
            <td><?php echo "<a href = 'show_project_details.php?id={$project_id}'>{$project_name}</a>"; ?></td>
            <td><?php echo $ticket['developer_assigned']; ?></td>
            <td><?php echo $ticket['ticket_status_name']; ?></td>
            <td><?php echo $ticket['ticket_type_name'];  ?></td>
            <td><?php echo $ticket['ticket_priority_name'];  ?></td>
            <td><?php echo $ticket['submitter']; ?></td>
            <td><?php echo $ticket['created_at'] ?></td>
        </tr>
    </table>

    <h2>Assign (new) developer to this ticket: </h2>
    <p>Search deloper: _____</p>
    <?php

    //selecct users not already enrolled in this project

    if (!isset($ticket['developer_assigned'])) {
        $ticket['developer_assigned'] = -1;
    }

    $sql = "SELECT username, user_id 
            FROM users 
            WHERE
            users.role = 2 
            AND
            user_id != {$ticket['developer_assigned']}
            AND user_id IN 
                (SELECT user_id 
                FROM project_enrollments 
                WHERE project_id=$project_id)";

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an associative array
    $not_assigned_devs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <nav>
        <ul>
            <?php if (!isset($not_assigned_devs[0])) : ?>
                <p> No developers are currently enrolled in this project </<sp>
                <?php endif ?>

                <?php foreach ($not_assigned_devs as $dev) : ?>

                    <li>
                        <?php echo $dev['username'] ?>
                        <form style="display:inline" action="includes/assign_to_ticket.inc.php" method="POST">
                            <input type="hidden" name="developer" value="<?php echo $dev['user_id']; ?>">
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                            <input type="hidden" name="project_name" value="<?php echo $project_name; ?>">

                            <input type="submit" value="Assign to ticket" name="assign_dev_submit">
                        </form>
                    </li>
                <?php endforeach; ?>
        </ul>
    </nav>



    <h2>Delete ticket</h2>

    <form action="includes/delete_ticket.inc.php" method="POST">
        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
        <input type="submit" name="delete_ticket_submit" value="Delete ticket">
    </form>



    <h2>Edit ticket</h2>

    <form action="includes/edit_ticket.php" method="POST">
        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
        <input type="submit" name="edit_ticket_submit" value="Edit ticket">
    </form>


    <h2>Ticket history: </h2>


    <h2>Add comment to ticket</h2>

    <h2>Ticket comments</h2>


    <?php
    // close connection
    mysqli_close($conn);
    ?>

    <?php
    // free result from memory (good practice)
    mysqli_free_result($result);
    ?>

</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>