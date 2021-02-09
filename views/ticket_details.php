<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');

$contr = new Controller();
$ticket_id = $_GET['ticket_id'];
if (isset($_POST['new_comment'])) {
    include('../classes/form_handlers/AddCommentHandler.class.php');
    $comment_handler = new AddCommentHandler($_SESSION['user_id'], $ticket_id, $_POST);
    $errors = $comment_handler->process_input();
}

$ticket = $contr->get_ticket_by_id($ticket_id);
$history_entries = $contr->get_ticket_history($ticket_id);
$files = array();
$comments = $contr->get_ticket_comments($ticket_id);

?>
<div class="main">
    <div class="ticket_details">
        <div class="card">
            <div class="w3-container card-head top">
                <h3>Ticket Details</h3>
                <a href="#" onclick="form_submitter('edit_ticket.php')"> Edit Ticket</a>
            </div>
            <div class="w3-container w3-responsive wrapper">
                <table class="table w3-small bordered">
                    <tr>
                        <td style="width:30%">Ticket ID</td>
                        <td><?php echo $ticket_id ?></td>
                    </tr>

                    <tr>
                        <td>Ticket name</td>
                        <td><?php echo $ticket['title'] ?></td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td><?php echo $ticket['description'] ?></td>
                    </tr>
                    <tr>
                        <td>Project</td>
                        <td><a href='#' onclick="form_submitter('project_details.php')"><?php echo $ticket['project_name'] ?> </a></td>
                    </tr>
                    <tr>
                        <td>Assigned Developer</td>
                        <td><?php echo $ticket['developer_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Submitter</td>
                        <td><?php echo $ticket['submitter_name'] ?></td>
                    </tr>
                </table>
                <table class=" table w3-small bordered">
                    <tr>
                        <td style="width:30%">Priority</td>
                        <td><?php echo $ticket['ticket_priority_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Type</td>
                        <td><?php echo $ticket['ticket_type_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $ticket['ticket_status_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Created</td>
                        <td><?php echo $ticket['created_at'] ?></td>
                    </tr>
                    <tr>
                        <td>Last update</td>
                        <td><?php echo $ticket['updated_at'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="wrapper">
            <div class="card left">
                <div class="w3-container card-head">
                    <h4>Ticket Comments</h4>
                </div>
                <div class="w3-container">
                    <h5>Add a comment?</h5>
                    <div class="w3-container" style="padding-bottom:0.6em;">
                        <p class="error"><?php echo $errors['comment'] ?? '' ?></p>
                        <form action="" method="post">
                            <input style="width:80%" type="text" name="new_comment" maxlength="200" placeholder="Write a comment on the ticket">
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
                            <input type="submit" class="btn-primary" style="width:5em;" value="ADD">
                        </form>
                    </div>
                </div>
                <h5 class="w3-container">All comments for this project</h5>
                <div class="w3-container w3-responsive">
                    <table class="table w3-small striped bordered">
                        <tr>
                            <th>Commenter</th>
                            <th>Message</th>
                            <th>Created</th>
                        </tr>
                        <?php foreach ($comments as $comment) : ?>
                            <tr>
                                <td><?php echo $comment['commenter'] ?></td>
                                <td><?php echo $comment['message'] ?></td>
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
            <div class="card right">
                <div class="w3-container card-head">
                    <h4>Ticket History</h4>
                </div>
                <h5 class="w3-container">All history information for this ticket</h5>

                <div class="w3-container w3-responsive">
                    <table class="table w3-small striped bordered">
                        <tr>
                            <th>Property</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Date Changed</th>
                        </tr>
                        <?php foreach ($history_entries as $history_entry) : ?>
                            <tr>
                                <td><?php echo $history_entry['event_type'] ?></td>
                                <td><?php echo $history_entry['old_value'] ?></td>
                                <td><?php echo $history_entry['new_value'] ?></td>
                                <td><?php echo $history_entry['created_at'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                    <?php if (count($history_entries) == 0) : ?>
                        <div class="empty-table-row">
                            <p>No changes have been made to this ticket</p>
                        </div>
                        <p class="entry-info">Showing 0-0 of 0 entries</p>
                    <?php else : ?>
                        <p class="entry-info">Showing 1-<?php echo count($history_entries); ?> of <?php echo count($history_entries); ?> entries</p>
                    <?php endif ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Model response message -->
<?php if (isset($_POST['show_ticket_edited_succes_message'])) : ?>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <h5>
                        You succesfully updated the the ticket
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id01').style.display = 'block';
    </script>
<?php endif ?>
</div>

<form action="" method="post" id="form">
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
    <input type="hidden" name="project_id" value="<?php echo $ticket['project_id'] ?>">
    <input type="hidden" name="go_to_edit_ticket" value="submit">
</form>

<script>
    function form_submitter(action) {
        document.getElementById('form').action = action;
        document.getElementById('form').submit();
    }
</script>


<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("my_tickets");
</script>