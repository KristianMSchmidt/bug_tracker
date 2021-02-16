<?php
require('../../control/shared/login_check.inc.php');
require('../../control/shared/check_project_permission.inc.php');
require('page_frame/ui_frame.php');

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
} else {
    header('location: dashboard.php');
}

$contr = new controller;
$project_permission = check_project_permission($contr, $_SESSION['user_id'], $project_id);
$project = $contr->get_project_by_id($project_id);
$users = $contr->get_project_users($project_id, "all_roles");
$tickets = $contr->get_tickets_by_project($project_id);
?>

<div class="main">
    <!-- All admins have acces. PM's enrolled in this project also have acces -->
    <?php if ($project_permission) : ?>
        <div class="user_details">
            <div class="card top project">
                <div class="w3-container card-head">
                    <h3>Project Details</h3>
                    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
                        <a href="edit_project.php?show_original=&project_id=<?php echo $project_id ?>">Edit Project</a>
                    <?php endif ?>
                </div>
                <div class="w3-container wrapper">
                    <table class="table bordered">
                        <tr>
                            <td class="td-details">Project Name:</td>
                            <td><?php echo $project['project_name'] ?></td>
                        </tr>

                        <tr>
                            <td class="td-details">Description:</td>
                            <td><?php echo $project['project_description'] ?></td>
                        </tr>
                        <tr>
                            <td class="td-details">Created By</td>
                            <td><?php echo $project['created_by'] ?></td>
                        </tr>
                    </table>
                    <table class="table bordered">

                        <tr>
                            <td class="td-details">Created</td>
                            <td><?php echo $project['created_at'] ?></td>

                        </tr>
                        <tr>
                            <td class="td-details">Last Update</td>
                            <td><?php echo $project['updated_at'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wrapper bottom project">
                <div class="left" style="flex:4;">
                    <form action="manage_project_users.php" method="get">
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        <input type="submit" name="got_to_manage_project_users" value="MANAGE PROJECT USERS" class="btn-primary">
                    </form>
                    <div class="card">
                        <div class="w3-container card-head">
                            <h4>Enrolled Personel</h4>
                        </div>
                        <div class="w3-container">
                            <h5>All users currently enrolled in this project</h5>
                        </div>
                        <div class="w3-container w3-small w3-responsive">
                            <table class="table striped bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Enrolled since</th>
                                </tr>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?php echo $user['full_name'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td><?php echo $user['role_name'] ?></td>
                                        <td><?php echo $user['enrollment_start'] ?></td>
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
                <div class="right" style="flex:5">
                    <form action="create_ticket.php" method="get">
                        <input type="hidden" name="project_options" value="false">
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        <input type="hidden" name="search" value="">
                        <input type="submit" value="ADD TICKET TO PROJECT" class="btn-primary">
                    </form>
                    <div class="card">
                        <div class="w3-container card-head">
                            <h4>Project Tickets</h4>
                        </div>
                        <div class="w3-container">
                            <h5>All tickets on this project</h5>
                        </div>
                        <div class="w3-container w3-responsive">
                            <table class="table striped w3-small bordered">
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
    <?php else : ?>
        <p>You don't have permission to this project. Please contact your local admin or project manager.</p>
    <?php endif ?>
</div>

<!-- Modal response message for created ticket -->
<?php if (isset($_SESSION['created_ticket_succes'])) : ?>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container modal-one-row-table">
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


<!-- Modal response message for edited project succes -->
<?php if (isset($_SESSION['edit_project_succes'])) : ?>
    <div id="id02" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container modal-one-row-table">
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

<?php
require('../../control/shared/clean_session.inc.php');
require('page_frame/closing_tags.php')

?>

<script>
    set_active_link("my_projects")
</script>