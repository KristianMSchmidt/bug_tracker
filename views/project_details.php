<?php
include('../includes/shared/login_check.inc.php');
include('shared/ui_frame.php');
$project_id = $_GET['project_id'];
$contr = new controller;
$project = $contr->get_project_by_id($project_id);
$users = $contr->get_project_users($project_id);
$tickets = $contr->get_tickets_by_project($project_id);
?>

<div class="main">
    <div class="project_details">
        <div class="card">
            <div class="w3-container card-head top" style="display:flex;">
                <h3>Project Details</h3>
                <a href="edit_project.php?show_original=&project_id=<?php echo $project_id ?>">Edit Project</a>
            </div>
            <div class=" w3-container">
                <table class="table bordered">
                    <tr>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Created</th>
                        <th>Last Update</th>
                    </tr>
                    <tr>
                        <td><?php echo $project['project_name'] ?></td>
                        <td><?php echo $project['project_description'] ?></td>
                        <td><?php echo $project['created_by'] ?></td>
                        <td><?php echo $project['created_at'] ?></th>
                        <td><?php echo $project['updated_at'] ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="bottom">
            <div class="bottom-left">
                <form action="manage_project_users.php" method="get">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input type="submit" name="got_to_manage_project_users" value="MANAGE PROJECT USERS" class="btn-primary">
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
                <form action="create_ticket.php" method="get">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input type="submit" value="ADD TICKET TO PROJECT" class="btn-primary">
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
                                    <td><a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id'] ?>">Details</a></td>
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
<?php if (isset($_SESSION['created_ticket_succes'])) : ?>
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
                                <td><?php echo $_SESSION['data']['title'] ?></td>
                                <td><?php echo $_SESSION['data']['description'] ?></td>
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


<!-- Model response message for edited project succes -->
<?php if (isset($_SESSION['edit_project_succes'])) : ?>
    <div id="id02" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <h5>
                        You succesfully edited this project
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id02').style.display = 'block';
    </script>
<?php endif ?>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>

<?php
include('../includes/shared/clean_session.inc.php');
?>