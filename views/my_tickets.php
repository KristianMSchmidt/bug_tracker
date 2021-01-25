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
$tickets_str = json_encode($tickets);

?>

<script>
    var tickets_js = <?php echo $tickets_str  ?>
</script>

<div class="main">

    <div class="my_tickets">

        <div class="card">
            <div class="container card-head">
                <h2>My tickets</h2>
            </div>
            <div class="container">

                <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                    <p>All tickets in the database</p>
                <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                    <p>All tickets to the projects that you manage </p>
                <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                    <p>All tickets that you are assigned to as developer </p>
                <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                    <p>All tickets that you have submitted </p>
                <?php endif ?>

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
                        <?php if (count($tickets) == 0) : ?>
                    </table>

                    <div class="empty-table-row">
                        <p>You have no tickets in the database</p>
                    </div>
                </div>
                <p>Showing 0-0 of 0 entries</p>
            </div>
        <?php else : ?>
            <?php
                            $j = count($tickets);
                            for ($i = 0; $i < $j; $i++) :
                                $ticket = $tickets[$i] ?>

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
                            <li><a href="#" onclick="edit_ticket_form_submitter(<?php echo $i ?>)">Edit</a></li>
                            <li><a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id'] ?>">Details</a></li>
                        </ul>
                    </td>
                </tr>
            <?php endfor ?>
            </table>
        </div>
        <p>Showing ticket 1-<?php echo count($tickets); ?> out of <?php echo count($tickets); ?>.</p>
    </div>
<?php endif ?>
</div>

<form action="edit_ticket.php" method="post" id="edit_ticket_form">
    <input type="hidden" name="ticket_json" id="ticket_json" value="">
    <input type="hidden" name="requested_action" value="show_edit_ticket_form">
</form>

<script>
    function edit_ticket_form_submitter(i) {
        document.getElementById("ticket_json").value = JSON.stringify(tickets_js[i]);
        document.getElementById("edit_ticket_form").submit()
    }
</script>

<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("my_tickets")
</script>