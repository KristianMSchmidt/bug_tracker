<?php
/* How it should work 
Administrators should see all tickets in the database
Project Managers should see all tickets to the projects they are enrolled in or are submitter 
Developers should seea ll tickets that they are assigned to as 'assigned developer' OR submitteer (change this)
Submitters should see all tickets they have submitted (os are dev assigned)
*/

require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');

$contr = new Controller;
$tickets = $contr->get_user_tickets_details($_SESSION['user_id'], $_SESSION['role_name'], $_GET['order'], $_GET['dir']);
?>

<div class="main">
    <div class="my_tickets">
        <div class="wrapper">
            <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
                <form action="create_ticket.php?project_options=false" method="get">
                    <input type="hidden" name="project_options" value="true">
                    <input type="hidden" name="project_id" value="none">
                    <input type="hidden" name="search">
                    <input type="submit" value="CREATE NEW TICKET" class="btn-primary">
                </form>
            <?php endif ?>
            <div class="card w3-responsive">
                <div class="w3-container card-head">
                    <h3>My Tickets</h3>
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
                <div class="w3-container w3-responsive">
                    <table class="w3-table w3-small w3-striped w3-bordered">
                        <tr>
                            <th><a href="#" onclick="reorder('my_tickets','title','<?php echo $_GET['dir'] ?>')">Title</a></th>
                            <th><a href="#" onclick="reorder('my_tickets','project_name','<?php echo $_GET['dir'] ?>')"> Project Name</a></th>
                            <th class="hide_last"><a href="#" onclick="reorder('my_tickets','ticket_priority_name','<?php echo $_GET['dir'] ?>')">Ticket Priority</a></th>
                            <th><a href="#" onclick="reorder('my_tickets','ticket_status_name','<?php echo $_GET['dir'] ?>')">Ticket Status</a></th>
                            <th class="hide_if_needed"><a href="#" onclick="reorder('my_tickets','ticket_type_name','<?php echo $_GET['dir'] ?>')">Ticket Type</a></th>
                            <th class="hide_if_needed"><a href="#" onclick="reorder('my_tickets','developer_name','<?php echo $_GET['dir'] ?>')">Developer Assigned</a></th>
                            <th class="hide_if_needed"><a href="#" onclick="reorder('my_tickets','submitter_name','<?php echo $_GET['dir'] ?>')"> Submitter</a></th>
                            <th class="hide_last"><a href="#" onclick="reorder('my_tickets','updated_at','<?php echo $_GET['dir'] ?>')">Last Update</a></th>
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
                                <td class="hide_last"><?php echo $ticket['updated_at'] ?></td>
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