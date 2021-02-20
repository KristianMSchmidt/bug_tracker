<?php
require('../../control/shared/login_check.inc.php');
require_once('../../control/controller.class.php');

$contr = new Controller();

if (!(isset($_GET['show_original']) || isset($_SESSION['ticket']['ticket_id']))) {
    header('location: dashboard.php');
}
if (isset($_GET['show_original'])) {
    $ticket_id = $_GET['ticket_id'];
    $_SESSION['ticket'] = $contr->get_ticket_by_id($ticket_id);
}
$project_id = $_SESSION['ticket']['project_id'];
$ticket_id = $_SESSION['ticket']['ticket_id'];
$project_permission = $contr->check_project_details_permission($_SESSION['user_id'], $_SESSION['role_name'], $project_id);
$ticket_details_permission = $contr->check_ticket_details_permission($_SESSION['user_id'], $_SESSION['role_name'], $_SESSION['ticket']);
$selected_project = $contr->get_project_by_id($project_id);
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();
$enrolled_developers = $contr->get_project_users($project_id, 3);
require('page_frame/ui_frame.php');

?>

<div class="main">
    <!-- Only certain users are allowed edit ticket: -->
    <?php if ($ticket_details_permission && in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
        <div class="edit_ticket">
            <div class="top">
                <!-- Parent Project -->
                <div class="card">
                    <div class="w3-container card-head">
                        <h3>Parent Project</h4>
                    </div>
                    <div style="padding-left:2em;">
                        <table class="w3-table w3-bordered table-no-description">
                            <tr>
                                <th>Project Name</th>
                                <th>Created</th>
                                <th>Last Update</th>
                                <th>Project Details</th>
                            </tr>
                            <tr>
                                <td><?php echo $selected_project['project_name']; ?></td>
                                <td><?php echo $selected_project['created_at']; ?></td>
                                <td><?php echo $selected_project['updated_at']; ?></td>
                                <?php if ($project_permission) : ?>
                                    <td> <a href="project_details.php?project_id=<?php echo $project_id ?>" class="right">Project Details</a></td>
                                <?php else : ?>
                                    <td>No permit <i>(you are not enrolled)</i>)</td>
                                <?php endif ?>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Edit Ticket</h3>
                    <a href="ticket_details.php?ticket_id=<?php echo $ticket_id ?>">Ticket Details</a>
                </div>
                <div class="card-content">
                    <form action="../../control/edit_ticket.inc.php" method="post" class="w3-container" id="edit_ticket_form">
                        <div class="text-input">
                            <div class="left">
                                <!-- Title -->
                                <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
                                    <p>
                                        <input type="text" name="title" class="w3-input title" maxlength="30" value="<?php echo $_SESSION['ticket']['title'] ?? '' ?>">
                                        <label>Ticket Title</label><br>
                                        <span class="error">
                                            <?php echo $_SESSION['errors']['title'] ?? '' ?>
                                        </span>
                                    </p>
                                <?php else : ?>
                                    <p><?php echo $_SESSION['ticket']['title'] ?? '' ?></p>
                                <?php endif ?>

                            </div>
                            <div class="right">
                                <!-- Description -->
                                <p>
                                    <input type="text" name="description" class="w3-input" maxlength="200" value="<?php echo $_SESSION['ticket']['description'] ?? '' ?>">
                                    <label>Description</label><br>
                                    <span class="error">
                                        <?php echo $_SESSION['errors']['description'] ?? '' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="other-input">
                            <div class="left">

                                <!-- Ticket Priority -->
                                <select class="w3-select" name="priority_id">
                                    <option value="<?php echo $_SESSION['ticket']['priority_id'] ?>" selected><?php echo $_SESSION['ticket']['ticket_priority_name']; ?></option>
                                    <?php foreach ($priorities as $priority) : ?>
                                        <?php if ($priority['id'] !== $_SESSION['ticket']['priority_id']) : ?>
                                            <option value="<?php echo $priority['id'] ?>"><?php echo $priority['ticket_priority_name'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                                <label>Ticket Priority</label>

                                <!-- Ticket Type -->
                                <select class="w3-select" name="type_id">
                                    <option value="<?php echo $_SESSION['ticket']['type_id'] ?>" selected><?php echo $_SESSION['ticket']['ticket_type_name'] ?></option>
                                    <?php foreach ($types as $type) : ?>
                                        <?php if ($type['ticket_type_id'] !== $_SESSION['ticket']['type_id']) : ?>
                                            <option value="<?php echo $type['ticket_type_id'] ?>"><?php echo $type['ticket_type_name'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                                <label>Ticket Type</label>
                            </div>
                            <div class="right">

                                <!-- Developer Assigned -->
                                <select class="w3-select" name="developer_assigned_id">
                                    <option value="<?php echo $_SESSION['ticket']['developer_assigned_id'] ?>" selected><?php echo $_SESSION['ticket']['developer_name'] ?></option>
                                    <?php foreach ($enrolled_developers as $enrolled_developer) : ?>
                                        <?php if ($enrolled_developer['user_id'] !== $_SESSION['ticket']['developer_assigned_id']) : ?>
                                            <option value="<?php echo $enrolled_developer['user_id'] ?>"><?php echo $enrolled_developer['full_name'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                                <label>Assigned Developer</label>

                                <!-- Ticket Status -->
                                <select class="w3-select" name="status_id">
                                    <option value="<?php echo $_SESSION['ticket']['status_id'] ?>" selected><?php echo $_SESSION['ticket']['ticket_status_name'] ?></option>
                                    <?php foreach ($status_types as $status_type) : ?>
                                        <?php if ($status_type['ticket_status_id'] !== $_SESSION['ticket']['status_id']) : ?>
                                            <option value="<?php echo $status_type['ticket_status_id'] ?>"><?php echo $status_type['ticket_status_name'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                                <label>Ticket Status</label>

                                <!-- Ticket Id -->
                                <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">

                                <!-- Project Id -->
                                <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                            </div>
                        </div>
                    </form>
                    <!-- Error Message -->
                    <p class=" error w3-center">
                        <?php echo $_SESSION['errors']['no_changes_error'] ?? '' ?>
                    </p>
                </div>

            </div>
            <!-- Submit button -->
            <div class="w3-container w3-center">
                <input type="submit" name="edit_submit" class="btn-primary below-card" value="Make Changes" form="edit_ticket_form">
            </div>
        </div>
        <form action="ticket_details.php" method="get" id="details_form">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
        </form>
    <?php else : ?>
        <p>You don't have permission to edit this ticket. Please contact your local administrator or project manager</p>
    <?php endif ?>
</div>


<?php
require('page_frame/closing_tags.php');
?>


<script>
    set_active_link("my_tickets")
</script>