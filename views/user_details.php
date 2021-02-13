<?php
require('../control/shared/login_check.inc.php');
require('shared/ui_frame.php');
$user_id = $_GET['user_id'];

$contr = new controller;
$user = $contr->get_users($user_id)[0];
$projects = $contr->get_projects_by_user($user_id, $user['role_name']);
$tickets = $contr->get_tickets_by_user($user_id, $user['role_name']);
?>

<div class="main">
    <div class="user_details">
        <div class="card top">
            <div class="w3-container card-head" style="display:flex;">
                <h3>User Details</h3>
                <a href="manage_user_roles.php?user_id=<?php echo $user_id ?>">Update Role</a>
            </div>
            <div class=" w3-container wrapper">
                <table class="table bordered">
                    <tr>
                        <td style="width:165px">Full Name:</td>
                        <td><?php echo $user['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $user['email'] ?></td>
                    </tr>
                    <tr>
                        <td>Role:</td>
                        <td><?php echo $user['role_name'] ?></td>
                    </tr>
                </table>
                <table class=" table bordered">
                    <tr>
                        <td style="width:165px">Created:</td>
                        <td><?php echo $user['created_at'] ?></th>
                    <tr>
                        <td>Last Update:</td>
                        <td><?php echo $user['updated_at'] ?></td>

                    <tr>
                        <td>Updated By:</td>
                        <td><?php echo $user['updated_by'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="wrapper bottom">
            <div class="left">
                <div class="card">
                    <div class="w3-container card-head">
                        <h4>Project Enrollments</h4>
                    </div>
                    <div class="w3-container">
                        <h5>User's Projects</h5>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Project Name</th>
                                <th>Enrollment started</th>
                            </tr>
                            <?php foreach ($projects as $project) : ?>
                                <?php $enrollment_start = $contr->get_enrollment_start($project['project_id'], $user_id);
                                print_r($enrollment_start);
                                exit(); ?>
                                <tr>
                                    <td><?php echo $project['project_name'] ?>
                                    </td>
                                    <td><?php echo "..."; ?></td>
                                    <td><a href="project_details.php?project_id=<?php echo $project['project_id'] ?>">Details</a></td>
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
            <div class="right">
                <div class="card">
                    <div class="w3-container card-head">
                        <h4>Tickets</h4>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Title</th>
                                <th>Submitter</th>
                                <th>Developer</th>
                                <th>Project</th>
                            </tr>

                            <?php foreach ($tickets as $ticket) : ?>
                                <tr>
                                    <td><?php echo $ticket['title'] ?></td>
                                    <td><?php echo $ticket['submitter_name'] ?></td>
                                    <td><?php echo $ticket['developer_name'] ?></td>
                                    <td><?php echo $ticket['project_name'] ?></td>

                                    <td><a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id'] ?>">Details</a></td>
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
require('../control/shared/clean_session.inc.php');
require('shared/closing_tags.php')
?>

<script>
    set_active_link("my_users")
</script>