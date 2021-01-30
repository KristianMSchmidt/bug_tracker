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
                <h4>
                    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                        All tickets in your database
                    <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                        All tickets to the projects that you manage
                    <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                        All tickets that you are assigned to as developer
                    <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                        All tickets that you have submitted
                    <?php endif ?>
                </h4>
                <div class="container w3-responsive">
                    <table class="table w3-small striped bordered">
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
                        <?php
                        //$tickets = array();
                        ?>
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
                                <td style="padding-left: 3em;">
                                    <ul style="padding:0; margin:0;">
                                        <li><a href="#" onclick="edit_ticket_form_submitter(<?php echo $ticket['ticket_id'] ?>)">Edit</a></li>
                                        <li><a href="#" onclick="ticket_details_submitter(<?php echo $ticket['ticket_id'] ?>)">Details</a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                    <?php if (count($tickets) == 0) : ?>
                        <div class="empty-table-row">
                            <p>You have no tickets in the database</p>
                        </div>
                    <?php endif ?>
                    <p style="font-size:12px">Showing ticket 0-<?php echo count($tickets); ?> of <?php echo count($tickets); ?>.</p>

                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="post" id="form">
    <input type="hidden" name="ticket_id" id="ticket_id" value="">
    <input type="hidden" name="requested_action" value="">
</form>


<script>
    function edit_ticket_form_submitter(ticket_id) {
        document.getElementById("ticket_id").value = ticket_id;
        document.getElementById("form").action = "edit_ticket.php";
        document.getElementById("form").submit()
    }

    function ticket_details_submitter(ticket_id) {
        document.getElementById("ticket_id").value = ticket_id;
        document.getElementById("form").action = "ticket_details.php"
        document.getElementById("form").submit()
    }
</script>

<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("my_tickets")
</script>