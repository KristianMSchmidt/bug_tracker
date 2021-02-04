<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$project = $contr->get_project_by_id($_POST['project_id']);
$users = $contr->get_project_users($_POST['project_id']);
$tickets = $contr->get_tickets_by_project($_POST['project_id']);
?>

<div class="main">
    <div class="project_details">
        <div class="w3-container">
            <div class="card">
                <div class="w3-container card-head top">
                    <h2>Project Details</h2>
                    <a href="#" onclick="document.getElementById('go_to_edit_form').submit()"> Edit Project</a>
                </div>
                <div class="w3-container">
                    <table class="table bordered">
                        <tr>
                            <th>Project ID</th>
                            <th>Project Name</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td style="width:15%"><?php echo $_POST['project_id'] ?></td>
                            <td style="width:35%"><?php echo $project['project_name'] ?></td>
                            <td style="width:50%"><?php echo $project['project_description'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="bottom w3-container">
            <div class="bottom-left">
                <form action="manage_project_users.php" method="post">
                    <input type="hidden" name="project_id" value="<?php echo $_POST['project_id']; ?>">
                    <input type="submit" value="MANAGE PROJECT USERS" class="btn-primary large" style="width: 16em;">
                </form>
                <div class="card">
                    <div class="w3-container card-head">
                        <h4>Assigned Personel</h4>
                    </div>
                    <div class="w3-container">
                        <h5>Current Users on this Project</h5>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user['full_name'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><?php echo $user['role_name'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                        <?php if (count($users) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no users assigned to this project</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo count($users); ?> of <?php echo count($users); ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="bottom-right">
                <form action="create_ticket.php" method="post">
                    <input type="hidden" name="project_id" value="<?php echo $_POST['project_id']; ?>">
                    <input type="hidden" name="requested_action" value="go_to_create_ticket_page">
                    <input type="submit" value="CREATE NEW TICKET" class="btn-primary large">
                </form>
                <div class="card">
                    <div class="w3-container card-head">
                        <h4>Tickets for this Project</h4>
                    </div>
                    <div class="w3-container">

                        <h5>Condensed Ticket Details</h5>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
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
                                    <td><?php echo explode(" ", $ticket['created_at'])[0] ?></td>
                                    <td><a href="#" onclick="ticket_details_submitter(<?php echo $ticket['ticket_id'] ?>)">Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php if (count($tickets) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no tickets for this project in the database</p>
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

<!-- Model response message for created ticket -->
<?php if ($_POST['requested_action'] == 'show_created_ticket_succes_message') : ?>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <h5>
                        You succesfully created a new ticket for this project:
                    </h5>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Ticket Title</th>
                                <th>Ticket Description</th>
                            </tr>
                            <tr>
                                <td><?php echo $_POST['ticket_title'] ?></td>
                                <td><?php echo $_POST['ticket_description'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id01').style.display = 'block';
    </script>
<?php endif ?>


<!-- Model response message for created ticket -->
<?php if ($_POST['requested_action'] == 'show_project_edited_succes_message') : ?>
    <div id="id02" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <h5>
                        You succesfully edited this project.
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id02').style.display = 'block';
    </script>
<?php endif ?>

<form action="ticket_details.php" method="post" id="form">
    <input type="hidden" name="ticket_id" id="ticket_id" value="">
    <input type="hidden" name="requested_action" value="">
</form>


<script>
    function ticket_details_submitter(i) {
        document.getElementById("ticket_id").value = i;
        document.getElementById("form").submit()
    }
</script>


<form action="edit_project.php" method="post" id="go_to_edit_form">
    <input type="hidden" name="project_id" value=<?php echo $project['project_id'] ?>>
    <input type="hidden" name="old_project_name" value=<?php echo $project['project_name'] ?>>
    <input type="hidden" name="old_project_description" value=<?php echo $project['project_description'] ?>>
    <input type="hidden" name="go_to_edit_project" value="">
</form>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>