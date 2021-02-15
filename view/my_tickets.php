<?php
/* How it should work 
Administrators should see all tickets in the database
Project Managers should see all tickets to the projects they are enrolled in or are submitter 
Developers should seea ll tickets that they are assigned to as 'assigned developer' OR submitteer (change this)
Submitters should see all tickets they have submitted (os are dev assigned)
*/

require('../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');

$contr = new Controller;
$tickets = $contr->get_tickets_by_user($_SESSION['user_id'], $_SESSION['role_name']);
?>

<div class="main">
    <div class="my_tickets">
        <div class="wrapper">
            <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
                <form action="create_ticket.php" method="get">
                    <input type="hidden" name="add_to_project" value="0">
                    <input type="submit" value="CREATE NEW TICKET" class="btn-primary">
                </form>
            <?php endif ?>
            <div class="card w3-responsive">
                <div class="w3-container card-head">
                    <h3>My tickets</h3>
                </div>
                <div class="w3-container">
                    <p>
                        <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                            All tickets in the database
                        <?php else : ?>
                            All your tickets in the database
                        <?php endif ?>
                    </p>
                </div>
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
                            <th>Ticket Details</th>
                        </tr>

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
                                <td><a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id'] ?>">Details</a></td>
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


<?php require('page_frame/closing_tags.php')
?>
<script>
    set_active_link("my_tickets")
</script>