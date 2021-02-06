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
        <div class="wrapper">
            <div class="card w3-responsive">
                <div class="w3-container card-head">
                    <h2>My tickets</h2>
                </div>
                <div class="w3-container">
                    <p>
                        <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                            All tickets in the database
                        <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                            All tickets to the projects you manage
                        <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                            All tickets you are assigned to as developer
                        <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                            All tickets you have submitted
                        <?php endif ?>
                    </p>
                </div>
                <div class="w3-container card-content">
                    <div class="w3-container w3-responsive card-content">
                        <table class="table w3-small striped bordered">
                            <tr>
                                <th>Title</th>
                                <th> Project Name</th>
                                <th class="hide_last">Ticket Priority</th>
                                <th>Ticket Status</th>
                                <th class="hide_if_needed">Ticket Type</th>
                                <th class="hide_if_needed">Developer Assigned</th>
                                <th class="hide_if_needed"> Submitter</th>
                                <th class="hide_last">Created</th>
                            </tr>
                            <?php
                            //$tickets = array();
                            ?>
                            <?php foreach ($tickets as $ticket) : ?>
                                <tr>
                                    <td><?php echo $ticket['title'] ?></td>
                                    <td><?php echo $ticket['project_name'] ?></td>
                                    <td class="hide_last"><?php echo $ticket['ticket_priority_name'] ?></td>
                                    <td><?php echo $ticket['ticket_status_name'] ?></td>
                                    <td class="hide_if_needed"><?php echo $ticket['ticket_type_name'] ?></td>
                                    <td class="hide_if_needed"><?php echo $ticket['developer_name'] ?></td>
                                    <td class="hide_if_needed"><?php echo $ticket['submitter_name'] ?></td>
                                    <td class="hide_last"><?php echo $ticket['created_at'] ?></td>
                                    <td><a href="#" onclick="ticket_details_submitter(<?php echo $ticket['ticket_id'] ?>)">Details</a></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                        <?php if (count($tickets) == 0) : ?>
                            <div class="empty-table-row">
                                <p>You have no tickets in the database</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo count($tickets); ?> of <?php echo count($tickets); ?> entries</p>
                        <?php endif ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<form action="ticket_details.php" method="post" id="form">
    <input type="hidden" name="ticket_id" id="ticket_id" value="">
    <input type="hidden" name="requested_action" value="">
</form>


<script>
    function ticket_details_submitter(ticket_id) {
        document.getElementById("ticket_id").value = ticket_id;
        document.getElementById("form").submit()
    }
</script>

<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("my_tickets")
</script>