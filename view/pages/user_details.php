<?php
require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    header('location: dashboard.php');
}

$contr = new controller;
$user = $contr->get_users($user_id)[0];
$projects = $contr->get_project_enrollments_by_user_id($user_id);
//Dirty fix to get the right tickets for Admin & PM using existing code. I'll clean this code later. 
//Here I only want to show ticket where the user in questing is either developer assigned or submitter
$tickets = $contr->get_tickets_by_user_and_role($user_id, 'Developer');

?>

<div class="main">
    <div class="user_details">
        <div class="card top">
            <div class="w3-container card-head" style="display:flex;">
                <h3>User Details</h3>
                <?php if (in_array($_SESSION['role_name'], ['Admin'])) : ?>
                    <a href="manage_user_roles.php?user_id=<?php echo $user_id ?>">Update Role</a>
                <?php endif ?>
            </div>
            <div class=" w3-container wrapper">
                <table class="table bordered">
                    <tr>
                        <td class="td-details">Full Name:</td>
                        <td><?php echo $user['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="td-details">Email:</td>
                        <td><?php echo $user['email'] ?></td>
                    </tr>
                    <tr>
                        <td class="td-details">Role:</td>
                        <td><?php echo $user['role_name'] ?></td>
                    </tr>
                </table>
                <table class=" table bordered">
                    <tr>
                        <td class="td-details">Created:</td>
                        <td><?php echo $user['created_at'] ?></th>
                    <tr>
                        <td class="td-details">Last Update:</td>
                        <td><?php echo $user['updated_at'] ?></td>
                </table>
            </div>
        </div>
        <div class="wrapper bottom">
            <div class="left" style="flex:2">
                <div class="card">
                    <div class="w3-container card-head">
                        <h4>Project Enrollments</h4>
                    </div>
                    <div class="w3-container">
                        <h6>The selected user is enrolled in these projects</h6>
                    </div>
                    <div class="w3-container">
                        <table class="table striped bordered">
                            <tr>
                                <th>Project Name</th>
                                <th>Enrollment started</th>
                                <th></th>
                            </tr>
                            <?php foreach ($projects as $project) : ?>
                                <?php $project_name = $contr->get_project_name_by_id(($project['project_id'])) ?>
                                <tr>
                                    <td><?php echo $project_name ?></td>
                                    <td><?php echo $project['enrollment_start'] ?></td>
                                    <td><a href="project_details.php?project_id=<?php echo $project['project_id'] ?>">Project Details</a></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                        <?php if (count($projects) == 0) : ?>
                            <div class=" empty-table-row">
                                <p>This user is not enrolled in any projects</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo count($projects); ?> of <?php echo count($projects); ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="right" style="flex:3" ;>
                <div class="card">
                    <div class="w3-container card-head">
                        <h4>Tickets</h4>
                    </div>
                    <div class="w3-container">
                        <h6>The selected user is developer assigned or submitter on these tickets</h6>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Title</th>
                                <th>Submitter</th>
                                <th>Developer</th>
                                <th>Project</th>
                                <th></th>
                            </tr>

                            <?php foreach ($tickets as $ticket) : ?>
                                <tr>
                                    <td><?php echo $ticket['title'] ?></td>
                                    <td><?php echo $ticket['submitter_name'] ?></td>
                                    <td><?php echo $ticket['developer_name'] ?></td>
                                    <td><?php echo $ticket['project_name'] ?></td>

                                    <td><a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id'] ?>">Ticket Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php if (count($tickets) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no tickets for this user in the database</p>
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

<?php
require('../../control/shared/clean_session.inc.php');
require('page_frame/closing_tags.php')

?>

<script>
    set_active_link("my_users")
</script>