<?php

/*
Administrators will see all tickets in the database
Project Managers will see all tickets to the projects they are enrolled in
Developers will see all tickets that they are assigned to as 'assigned developer'
Submitters will see all tickets they have submitted
*/

include('../includes/login_check.inc.php');
include('shared/ui_frame.php');

$contr = new Controller;
$tickets = $contr->get_tickets_by_user($_SESSION['user_id'], $_SESSION['role_name']);
?>


<div class="main">

    <div class="my_tickets">

        <div class="card">
            <div class="container card-head">
                <h2>My tickets</h2>
            </div>
            <div class="container">
                <p>
                    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                <p>All tickets in the database</p>
            <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                <p>All tickets to the projects that you manage </p>
            <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                <p>All tickets that you are assigned to as developer </p>
            <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                <p>All tickets that you have submitted </p>
            <?php endif ?>
            </p>
            <div class="container w3-responsive">
                <table class="table striped bordered">
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
                            <td>
                                <a href="#">Edit/Assign</a>
                                <a href="">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <p>Showing project 1-<?php echo count($tickets); ?> out of <?php echo count($tickets); ?>.</p>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_tickets")
</script>