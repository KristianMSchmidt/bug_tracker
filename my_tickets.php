<?php
/*
Administrators will see all tickets in the database
Project Managers will see all tickets to the projects they are enrolled in
Developers will see all tickets that they are assigned to as 'assigned developer'
Submitters will see all tickets they have submitted
*/
require 'templates/ui_frame.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


// connect to db
include('includes/db_connect.inc.php');

$sql =
    "SELECT 
    tickets.title,
    tickets.created_at,
    tickets.developer_assigned,
    tickets.submitter,
    projects.project_name,
    ticket_priorities.ticket_priority_name,
    ticket_status_types.ticket_status_name,
    ticket_types.ticket_type_name,
    s.username AS submitter_name,  /* alias necessary */
    d.username AS developer_name  /* alias necessary */
    FROM tickets 
    JOIN users s ON tickets.submitter = s.user_id
    JOIN users d ON tickets.developer_assigned = d.user_id
    JOIN projects ON tickets.project = projects.project_id
    JOIN ticket_status_types ON tickets.type = ticket_status_types.ticket_status_id
    JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id
    JOIN ticket_types ON tickets.type =ticket_types.ticket_type_id";

// add conditions to sql depending on user type
if ($_SESSION['role_name'] == 'Project Manager') :
    $sql .= " WHERE tickets.project IN 
              (SELECT project_id FROM project_enrollments WHERE user_id = {$_SESSION['user_id']})";

elseif ($_SESSION['role_name'] == 'Developer') :
    $sql .= " WHERE tickets.developer_assigned = {$_SESSION['user_id']}";

elseif ($_SESSION['role_name'] == 'Submitter') :
    $sql .= " WHERE tickets.submitter = {$_SESSION['user_id']}";
endif;

$sql .= " ORDER BY tickets.created_at DESC";


// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$tickets = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>

<div class="main" style="margin-left:4em; margin-right:4em;">

    <h2>Your Tickets</h2>

    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
        <p>All tickets in the database</p>
    <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
        <p>All tickets to the projects that you manage </p>
    <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
        <p>All tickets that you are assigned to as developer </p>
    <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
        <p>All tickets that you have submitted </p>
    <?php endif ?>

    <table style=" width:100%;">
        <tr>
            <th>Title</th>
            <th>Project Name</th>
            <th>Developer Assigned</th>
            <th>Ticket Priority</th>
            <th>Ticket Status</th>
            <th>Ticket Type</th>
            <th>Submitter</th>
            <th>Created</th>
        </tr>

        <?php foreach ($tickets as $ticket) : ?>
            <tr>
                <td><?php echo $ticket['title'] ?></td>
                <td><?php echo $ticket['project_name'] ?></td>
                <td><?php echo $ticket['developer_name'] ?></td>
                <td><?php echo $ticket['ticket_priority_name'] ?></td>
                <td><?php echo $ticket['ticket_status_name'] ?></td>
                <td><?php echo $ticket['ticket_type_name'] ?></td>
                <td><?php echo $ticket['submitter_name'] ?></td>
                <td><?php echo $ticket['created_at'] ?></td>
                <td style=" border:0px;">
                    <a href="#">Edit/Assign</a>
                    <a href="">Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>