<?php
require 'templates/ui_frame.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (!($_POST['project_id'])) {
    header('Location: my_projects.php');
    exit();
}
include('includes/db_connect.inc.php');

// query all personal enrolled in this project
$sql =
    "select users.username, users.email, role_name
    from users 
    join project_enrollments on users.user_id = project_enrollments.user_id
    join user_roles on user_roles.role_id = users.role_id
    where project_enrollments.project_id = {$_POST['project_id']}";

// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);


// query all tickets in this project
$sql =
    "SELECT 
        tickets.title,
        tickets.created_at,
        ticket_priorities.ticket_priority_name,
        ticket_status_types.ticket_status_name,
        ticket_types.ticket_type_name,
        s.username AS submitter_name,  /* alias necessary */
        d.username AS developer_name   /* alias necessary */
        FROM tickets 
        JOIN users s ON tickets.submitter = s.user_id
        JOIN users d ON tickets.developer_assigned = d.user_id
        JOIN projects ON tickets.project = projects.project_id
        JOIN ticket_status_types ON tickets.type = ticket_status_types.ticket_status_id
        JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id
        JOIN ticket_types ON tickets.type =ticket_types.ticket_type_id
        WHERE tickets.project = {$_POST['project_id']}";

// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$tickets = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<div class="main"">
    <div style=" color:white; width:90%; background-color:orange;margin:1em; margin: 0 auto; margin-top: 0.5em; padding: 0.05em; padding-left:1em; padding-bottom:1em;">
    <h3 style="margin-bottom:0em;margin-top:0.5em;padding-top:0em;">Details for Project #<?php echo $_POST['project_id'] ?></h3>
    <a style="color:white" href="my_projects.php">Back to list</a>
    <a style="color:white; padding:0.5em;" href="">Edit</a>
</div>
<div class="project_details_wrapper">
    <div style="border:1px solid black; margin-left:3em; ">
        <p style="margin-bottom:0.2em;margin-top:0;">Project Name:</p>
        <h4 style="margin:0; margin-left:1em;"><?php echo $_POST['project_name'] ?></h4>
    </div>
    <div style=" border:1px solid black">
        <p style="margin-bottom:0.2em;margin-top:0; ">Project Description</p>
        <h4 style="margin:0; margin-left:1em;"><?php echo $_POST['project_description'] ?></h4>
    </div>

    <div style="background-color:beige">
        <div style="color:white; width:85%; background-color:orange;margin:1em; margin: 0 auto;  margin-top: 0.5em; padding: 0.05em; padding-left:1em;">
            <h3 style="margin-bottom:0em;margin-top:0.5em;padding-top:0em;">Assigned personer</h3>
            <p style="margin-top:0;">Current Users on this project</p>
        </div>
        <br>
        <table style="width:95%; margin:0 auto;">
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>

            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['username'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['role_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div style=" background-color:beige">
        <div style="color:white; width:90%; background-color:orange;margin:1em; margin: 0 auto;  margin-top: 0.5em; padding: 0.05em; padding-left:1em;">
            <h3 style="margin-bottom:0em;margin-top:0.5em;padding-top:0em;">Tickets for this project</h3>
            <p style="margin-top:0;">Condensed Ticket Details</p>
        </div>
        <br>
        <table style="min-width:95%; margin:0 auto;">
            <tr>
                <th>Title</th>
                <th>Submitter</th>
                <th>Developer</th>
                <th>Status</th>
                <th>Created</th>
            </tr>

            <?php foreach ($tickets as $ticket) : ?>
                <tr>
                    <td><?php echo $ticket['title'] ?></td>
                    <td><?php echo $ticket['submitter_name'] ?></td>
                    <td><?php echo $ticket['developer_name'] ?></td>
                    <td><?php echo $ticket['ticket_status_name'] ?></td>
                    <td><?php echo $ticket['created_at'] ?></td>
                    <th><a href="#">More Details</a></th>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div> <!-- dashboard_wrapper -->
</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>