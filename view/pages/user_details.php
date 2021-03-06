<?php
require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    header('location: dashboard.php');
}
if (!isset($_GET['order1'])) {
    $_GET['order1'] = 'project_name';
    $_GET['dir1'] = 'asc';
    $_GET['order2'] = 'title';
    $_GET['dir2'] = 'asc';
}
$contr = new controller;
$user = $contr->get_user_details_by_id($user_id);
$projects = $contr->get_users_enrolled_projects_details($user_id, $_GET['order1'], $_GET['dir1']);
$project_details_permissions = $contr->check_multiple_project_details_permission($_SESSION['user_id'], $_SESSION['role_name'], $projects);
//Dirty fix to get the right tickets for Admin & PM using existing code. I'll clean this code later. 
//Here I only want to show ticket where the user in questing is either developer assigned or submitter
$tickets = $contr->get_user_tickets_details($user_id, 'Developer', $_GET['order2'], $_GET['dir2']);
$ticket_details_permissions = $contr->check_multiple_ticket_details_permission($_SESSION['user_id'], $_SESSION['role_name'], $tickets);
$project_count = count($projects);
$ticket_count = count($tickets);
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
            <div class="w3-container wrapper">
                <table class="w3-table w3-bordered">
                    <tr>
                        <td class="td-details">Full Name:</td>
                        <td><?php echo $user['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td class=" td-details">Email:</td>
                        <td><?php echo $user['email'] ?></td>
                    </tr>
                    <tr>
                        <td class="td-details">Role:</td>
                        <td><?php echo $user['role_name'] ?></td>
                    </tr>
                </table>
                <table class="w3-table w3-bordered">
                    <tr>
                        <td class="td-details">Created:</td>
                        <td><?php echo $user['created_at'] ?></th>
                    </tr>
                    <td class="td-details">Last Update:</td>
                    <td><?php echo $user['updated_at'] ?></td>
                    </tr>
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
                        <table class="w3-table w3-striped w3-bordered">
                            <tr>
                                <th><a href="#" onclick="double_reorder(1, 'project_name', '<?php echo $_GET['dir1']; ?>')">Project Name</a></th>
                                <th><a href="#" onclick="double_reorder(1, 'enrollment_start', '<?php echo $_GET['dir1']; ?>')">Enrolled Since</a></th>
                                <th>Project Details</th>
                            </tr>
                            <?php foreach ($projects as $project) : ?>
                                <tr>
                                    <td><?php echo $project['project_name']; ?></td>
                                    <td><?php echo $project['enrollment_start']; ?></td>
                                    <td>
                                        <?php if ($project_details_permissions[$project['project_id']]) : ?>
                                            <a href="project_details.php?project_id=<?php echo $project['project_id'] ?>">Details</a>
                                        <?php else : ?>
                                            No permit
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                        <?php if ($project_count == 0) : ?>
                            <div class=" empty-table-row">
                                <p>This user is not enrolled in any projects</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo $project_count; ?> of <?php echo $project_count; ?> entries</p>
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
                        <h6>The selected user is either the assigned developer or the submitter on these tickets</h6>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="w3-table w3-striped w3-bordered">
                            <tr>
                                <th><a href="#" onclick="double_reorder(2, 'title', '<?php echo $_GET['dir2']; ?>')">Title</a></th>
                                <th><a href="#" onclick="double_reorder(2, 'submitter_name','<?php echo $_GET['dir2']; ?>')">Submitter</a></th>
                                <th><a href="#" onclick="double_reorder(2, 'developer_name','<?php echo $_GET['dir2']; ?>')">Developer</a></th>
                                <th><a href="#" onclick="double_reorder(2, 'project_name','<?php echo $_GET['dir2']; ?>')">Project</a></th>
                                <th>Ticket Details</th>
                            </tr>

                            <?php foreach ($tickets as $ticket) : ?>
                                <tr>
                                    <td><?php echo $ticket['title'] ?></td>
                                    <td><?php echo $ticket['submitter_name'] ?></td>
                                    <td><?php echo $ticket['developer_name'] ?></td>
                                    <td><?php echo $ticket['project_name'] ?></td>
                                    <td>
                                        <?php if ($ticket_details_permissions[$ticket['ticket_id']]) : ?>
                                            <a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id'] ?>">Details</a>
                                        <?php else : ?> No permit
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                        <?php if ($ticket_count == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no tickets for this user in the database</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo $ticket_count; ?> of <?php echo $ticket_count; ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="get" id="reorder_form">
    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
    <input type="hidden" name="order1" id="order1" value="<?php echo $_GET['order1'] ?>">
    <input type="hidden" name="dir1" id="dir1" value="<?php echo $_GET['dir1'] ?>">
    <input type="hidden" name="order2" id="order2" value="<?php echo $_GET['order2'] ?>">
    <input type="hidden" name="dir2" id="dir2" value="<?php echo $_GET['dir2'] ?>">
</form>

<?php
require('page_frame/closing_tags.php');
?>

<script>
    set_active_link("users_overview");
</script>