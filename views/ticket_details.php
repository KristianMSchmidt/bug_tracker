<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include('shared/ui_frame.php');

$OFFSET = 0;
$LIMIT = 5;

$contr = new Controller();
$ticket_id = $_POST['ticket_id'];

if(isset($_POST['new_comment'])){
    include('../classes/form_handlers/AddCommentHandler.class.php');
    $comment_handler = new AddCommentHandler($_SESSION['user_id'], $ticket_id, $_POST);
    $errors = $comment_handler->process_input();
}

$ticket = $contr->get_ticket_by_id($ticket_id);
$history_entries = $contr->get_ticket_history($ticket_id, $OFFSET, $LIMIT);
$files = array();
$comments = $contr->get_ticket_comments($ticket_id);


if (isset($_POST['show_next'])) {
    $LIMIT = $_POST['LIMIT'];
    $OFFSET = $_POST['OFFSET'] + $LIMIT;
} else {
    //initial values
    $LIMIT = 2;
    $OFFSET = 0;
}

?>
<style>
    .entry-info {
        font-size: 12px;
    }
</style>
<div class="new_main">
    <?php
    ?>
    <div class="ticket_details">
        <div class="container">
            <h1>Details for Ticket #<?php echo $ticket_id ?></h1>
            <a href="#" onclick="form_submitter('project_details.php')" style="color:blue; margin-right:1em;">Go to Project </a>
            <a href="#" onclick="form_submitter('edit_ticket.php')" style="color:blue;"> Edit Ticket</a>
        </div>
        <br>
        <div class="grid-container">
            <div class="top-left">
                <div class="card">
                    <div class="container card-head">
                        <h3>Ticket Details</h3>
                    </div>
                    <div class="container w3-responsive">
                        <table class="table w3-small bordered">
                            <br>
                            <tr>
                                <td style="color:grey">Ticket name</td>
                                <td><?php echo $ticket['title'] ?></td>
                            </tr>

                            <tr>
                                <td style="color:grey">Description</td>
                                <td><?php echo $ticket['description'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Project</td>
                                <td><?php echo $ticket['project_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Assigned Developer</td>
                                <td><?php echo $ticket['developer_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Submitter</td>
                                <td><?php echo $ticket['submitter_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Priority</td>
                                <td><?php echo $ticket['ticket_priority_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Type</td>
                                <td><?php echo $ticket['ticket_type_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Status</td>
                                <td><?php echo $ticket['ticket_status_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Created</td>
                                <td><?php echo $ticket['created_at'] ?></td>
                            </tr>
                            <tr>
                                <td style="color:grey">Last update</td>
                                <td><?php echo $ticket['updated_at'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="top-right">

                <div class="card">
                    <div class="container card-head">
                        <h3>Ticket Comments</h3>
                    </div>
                    <div class="container">
                        <h5>Add a comment?</h5>
                        <div class="container" style="padding-bottom:0.6em;">
                            <p class="error"><?php echo $errors['comment'] ?? '' ?></p>
                            <form action="" method="post">
                                <input style="width:80%" type="text" name="new_comment" placeholder="Write a comment on the ticket">
                                <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
                                <input type="hidden" name="requested_action">                            
                                <input type="submit" class="btn-primary" style="width:5em;" value="ADD">                            
                            </form>
                        </div>
                    </div>
                    <h5 class="container">All comments for this project</h5>
                    <div class="container w3-responsive">
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
            </div>
            <div class="bottom-left">
                <div class="card">
                    <div class="container card-head">
                        <h3>Ticket History</h3>
                    </div>
                    <h5 class="container">All history information for this ticket</h5>

                    <div class="container w3-responsive">
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

            <div class="bottom-right">
                <div class="card">
                    <div class="container card-head">
                        <h3>Ticket Attachments</h3>
                    </div>
                    <div class="container">
                        <h5>Add an attachment?</h5>
                        <div class="container" style="padding-bottom:0.6em;">
                            <input style="width:80%" type="text" placeholder="Describe the attachment">
                            <input type="submit" class="btn-primary" style="width:5em;" value="ADD" onclick="alert('File upload not implemented yet!')">
                        </div>
                    </div>
                    <h5 class=" container">All files attached to this project</h5>
                    <div class="container w3-responsive">
                        <table class="table w3-small striped bordered">
                            <tr>
                                <th>File</th>
                                <th>Uploader</th>
                                <th>Notes</th>
                                <th>Created</th>
                            </tr>
                        </table>
                        <?php if (count($files) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no files for this ticket</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo count($files); ?> of <?php echo count($files); ?> entries</p>
                        <?php endif ?>   
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Model response message -->
     <?php if ($_POST['requested_action']=='show_succes_message'): ?>
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <div class="w3-container">
                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <div class="container">
                        <p style="margin-top:4em; margin-bottom:4em;">
                            You succesfully updated the the ticket
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('id01').style.display = 'block';
        </script>
    <?php endif ?>
</div>
<!--
<form action="ticket_details.php" method="post">
    OFFSET: <input type="number" name="OFFSET" id="offset" value=<?php echo $OFFSET ?>>
    LIMIT: <input type="number" name="LIMIT" id="limit" value=<?php echo $LIMIT ?>>
    <input type="hidden" name="ticket_id" value=<?php echo $_POST['ticket_id'] ?>>
    <input type="submit" name="show_next" value="Show next">

</form>
-->
<script>
    function f() {
        offset = document.getElementById("offset").value;
        limit = document.getElementById("limit").value;

    }
</script>

<form action="" method ="post" id="form">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
            <input type="hidden" name="project_id" value="<?php echo $ticket['project'] ?>">
            <input type="hidden" name="requested_action">
</form>
<script>
    function form_submitter(action){
        document.getElementById('form').action=action;
        document.getElementById('form').submit();
    }
</script>




<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("my_tickets");
</script>