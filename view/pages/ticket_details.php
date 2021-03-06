<?php
require('../../control/shared/login_check.inc.php');

require('page_frame/ui_frame.php');

$contr = new Controller();
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
} else {
    header('location: dashboard.php');
}
if (!isset($_GET['order1'])) {
    $_GET['order1'] = 'created_at';
    $_GET['dir1'] = 'desc';
    $_GET['order2'] = 'created_at';
    $_GET['dir2'] = 'desc';
}
$ticket = $contr->get_ticket_by_id($ticket_id);
$comments = $contr->get_ticket_comments($ticket_id, $_GET['order1'], $_GET['dir1']);
$ticket_events = $contr->get_ticket_events($ticket_id, $_GET['order2'], $_GET['dir2']);
$ticket_details_permission = $contr->check_ticket_details_permission($_SESSION['user_id'], $_SESSION['role_name'], $ticket);
?>

<div class="main">
    <?php if ($ticket_details_permission) : ?>
        <div class="ticket_details">
            <div class="card top">
                <div class="w3-container card-head">
                    <h3>Ticket Details</h3>
                    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
                        <a href="edit_ticket.php?ticket_id=<?php echo $ticket_id ?>&show_original=true">Edit Ticket</a>
                    <?php endif ?>
                </div>
                <div class="w3-container wrapper">
                    <table class="w3-table w3-bordered">
                        <tr>
                            <td class="td-details">Ticket name:</td>
                            <td><?php echo $ticket['title'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Project:</td>
                            <td><a href="project_details.php?project_id=<?php echo $ticket['project_id'] ?>"><?php echo $ticket['project_name'] ?> </a></td>
                        </tr>
                        <tr>
                            <td class="td-details">Developer:</td>
                            <td><?php echo $ticket['developer_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Submitter:</td>
                            <td><?php echo $ticket['submitter_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Description:</td>
                            <td><?php echo $ticket['description'] ?></td>
                        </tr>
                    </table>
                    <table class="w3-table w3-bordered">
                        <tr>
                            <td class="td-details">Priority:</td>
                            <td><?php echo $ticket['ticket_priority_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Type:</td>
                            <td><?php echo $ticket['ticket_type_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Status:</td>
                            <td><?php echo $ticket['ticket_status_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Created:</td>
                            <td><?php echo $ticket['created_at'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Last update:</td>
                            <td><?php echo $ticket['updated_at'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="wrapper bottom">
                <div class="left">
                    <div class="card">
                        <div class="w3-container card-head">
                            <h4>Ticket Comments</h4>
                        </div>
                        <div class="w3-container">
                            <h5>Add a comment?</h5>
                            <div class="w3-container">
                                <form action="../../control/ticket_details.inc.php" method="post">
                                    <input style="width:80%" type="text" name="new_comment" maxlength="200" placeholder="Write a comment on the ticket">
                                    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
                                    <input type="hidden" name="developer_assigned_id" value=<?php echo $ticket['developer_assigned_id']; ?>>
                                    <input type="submit" class="btn-primary" style="width:5em;" value="ADD">
                                </form>
                                <p class="error"><?php echo $_SESSION['errors']['comment'] ?? '' ?></p>
                            </div>
                        </div>
                        <h5 class="w3-container">All comments for this project</h5>
                        <div class="w3-container w3-responsive">
                            <table class="w3-table w3-small w3-striped w3-bordered">
                                <tr>
                                    <th><a href="#" onclick="double_reorder(1, 'commenter', '<?php echo $_GET['dir1']; ?>')">Commenter</a></th>
                                    <th><a href="#" onclick="double_reorder(1, 'comment', '<?php echo $_GET['dir1']; ?>')">Message</a></th>
                                    <th><a href="#" onclick="double_reorder(1, 'created_at', '<?php echo $_GET['dir1']; ?>')">Created</a></th>
                                </tr>
                                <?php foreach ($comments as $comment) : ?>
                                    <tr>
                                        <td><?php echo $comment['commenter'] ?></td>
                                        <td><?php echo $comment['comment'] ?></td>
                                        <td><?php echo $comment['created_at'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                            <?php if (count($comments) == 0) : ?>
                                <div class="empty-table-row">
                                    <p>There are no comments for this ticket</p>
                                </div>
                                <p class="entry-info">Showing 0-0 of 0 entries</p>
                            <?php else : ?>
                                <p class="entry-info">Showing 1-<?php echo count($comments); ?> of <?php echo count($comments); ?> entries</p>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="card">
                        <div class="w3-container card-head">
                            <h4>Ticket History</h4>
                        </div>
                        <h5 class="w3-container">All history information for this ticket</h5>

                        <div class="w3-container">
                            <table class="w3-table w3-small w3-striped w3-bordered">
                                <tr>
                                    <th><a href="#" onclick="double_reorder(2, 'ticket_event_type', '<?php echo $_GET['dir2']; ?>')">Property</a></th>
                                    <th><a href="#" onclick="double_reorder(2, 'old_value', '<?php echo $_GET['dir2']; ?>')">Old Value</a></th>
                                    <th><a href="#" onclick="double_reorder(2, 'new_value', '<?php echo $_GET['dir2']; ?>')">New Value</a></th>
                                    <th><a href="#" onclick="double_reorder(2, 'created_at', '<?php echo $_GET['dir2']; ?>')">Date Changed</a></th>
                                </tr>
                                <?php foreach ($ticket_events as $ticket_event) : ?>
                                    <tr>
                                        <td><?php echo $ticket_event['ticket_event_type'] ?></td>
                                        <td><?php echo $ticket_event['old_value'] ?></td>
                                        <td><?php echo $ticket_event['new_value'] ?></td>
                                        <td><?php echo $ticket_event['created_at'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                            <?php if (count($ticket_events) == 0) : ?>
                                <div class="empty-table-row">
                                    <p>No changes have been made to this ticket</p>
                                </div>
                                <p class="entry-info">Showing 0-0 of 0 entries</p>
                            <?php else : ?>
                                <p class="entry-info">Showing 1-<?php echo count($ticket_events); ?> of <?php echo count($ticket_events); ?> entries</p>
                            <?php endif ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>You don't have permission to see the details of this ticket. Please contact your local admin.</p>
    <?php endif ?>
</div>

<form action="" method="get" id="reorder_form">
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
    <input type="hidden" name="order1" id="order1" value="<?php echo $_GET['order1'] ?>">
    <input type="hidden" name="dir1" id="dir1" value="<?php echo $_GET['dir1'] ?>">
    <input type="hidden" name="order2" id="order2" value="<?php echo $_GET['order2'] ?>">
    <input type="hidden" name="dir2" id="dir2" value="<?php echo $_GET['dir2'] ?>">
</form>

<!-- Modal response message -->
<?php if (isset($_SESSION['edit_ticket_succes'])) : ?>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <h5>
                        You succesfully updated this ticket
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id01').style.display = 'block';
    </script>
<?php endif ?>

<?php
require('page_frame/closing_tags.php');
?>

<script>
    set_active_link("my_tickets");
</script>