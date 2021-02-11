<?php
require('../control/shared/login_check.inc.php');
require_once('../control/controller.class.php');

$contr = new Controller();

if (isset($_GET['show_original'])) {
    $ticket_id = $_GET['ticket_id'];
    $_SESSION['data'] = $contr->get_ticket_by_id($ticket_id);
}

$projects = $contr->get_projects();
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();
$developers = $contr->get_users_by_role_id(3);

require('shared/ui_frame.php');
?>

<div class="main">
    <div class="edit_ticket">
        <div class="card">
            <div class="w3-container card-head">
                <h3>Edit Ticket</h3>
                <a href="ticket_details.php?ticket_id=<?php echo $_SESSION['data']['ticket_id'] ?>">Ticket Details</a>
            </div>
            <div class="card-content">
                <form action="../control/edit_ticket.inc.php" method="post" class="w3-container">
                    <div class="text-input">
                        <div class="left">
                            <!-- Title -->
                            <p>
                                <input type="text" name="title" class="w3-input title" maxlength="30" value="<?php echo $_SESSION['data']['title'] ?? '' ?>">
                                <label>Ticket Title</label><br>
                                <span class="error">
                                    <?php echo $_SESSION['errors']['title'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                        <div class="right">
                            <!-- Description -->
                            <p>
                                <input type="text" name="description" class="w3-input" maxlength="200" value="<?php echo $_SESSION['data']['description'] ?? '' ?>">
                                <label>Description</label><br>
                                <span class="error">
                                    <?php echo $_SESSION['errors']['description'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="other-input">
                        <div class="left">
                            <!-- Project -->
                            <select class="w3-select" name="project_id">
                                <option value="<?php echo $_SESSION['data']['project_id'] ?>" selected><?php echo $_SESSION['data']['project_name']; ?></option>
                                <?php foreach ($projects as $project) : ?>
                                    <?php if ($project['project_id'] != $_SESSION['data']['project_id']) : ?>
                                        <option value="<?php echo $project['project_id'] ?>"><?php echo $project['project_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Project</label>

                            <!-- Ticket Priority -->
                            <select class="w3-select" name="priority_id">
                                <option value="<?php echo $_SESSION['data']['priority_id'] ?>" selected><?php echo $_SESSION['data']['ticket_priority_name']; ?></option>
                                <?php foreach ($priorities as $priority) : ?>
                                    <?php if ($priority['ticket_priority_id'] !== $_SESSION['data']['priority_id']) : ?>
                                        <option value="<?php echo $priority['ticket_priority_id'] ?>"><?php echo $priority['ticket_priority_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Priority</label>

                            <!-- Ticket Type -->
                            <select class="w3-select" name="type_id">
                                <option value="<?php echo $_SESSION['data']['type_id'] ?>" selected><?php echo $_SESSION['data']['ticket_type_name'] ?></option>
                                <?php foreach ($types as $type) : ?>
                                    <?php if ($type['ticket_type_id'] !== $_SESSION['data']['type_id']) : ?>
                                        <option value="<?php echo $type['ticket_type_id'] ?>"><?php echo $type['ticket_type_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Type</label>
                        </div>
                        <div class="right">

                            <!-- Developer Assigned -->
                            <select class="w3-select" name="developer_assigned">
                                <option value="<?php echo $_SESSION['data']['developer_assigned'] ?>" selected><?php echo $_SESSION['data']['developer_name'] ?></option>
                                <?php foreach ($developers as $developer) : ?>
                                    <?php if ($developer['user_id'] !== $_SESSION['data']['developer_assigned']) : ?>
                                        <option value="<?php echo $developer['user_id'] ?>"><?php echo $developer['full_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Assigned Developer</label>

                            <!-- Ticket Status -->
                            <select class="w3-select" name="status_id">
                                <option value="<?php echo $_SESSION['data']['status_id'] ?>" selected><?php echo $_SESSION['data']['ticket_status_name'] ?></option>
                                <?php foreach ($status_types as $status_type) : ?>
                                    <?php if ($status_type['ticket_status_id'] !== $_SESSION['data']['status_id']) : ?>
                                        <option value="<?php echo $status_type['ticket_status_id'] ?>"><?php echo $status_type['ticket_status_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Status</label>

                            <!-- Ticket Id -->
                            <input type="hidden" name="ticket_id" value="<?php echo $_SESSION['data']['ticket_id']; ?>">

                            <!-- Error Message -->
                            <p class="error w3-center">
                                <?php echo $_SESSION['errors']['no_changes_error'] ?? '' ?>
                            </p>
                            <!-- Submit button -->
                            <div class="w3-container w3-center">
                                <input type="submit" name="edit_submit" class="btn-primary" value="Make Changes">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form action="ticket_details.php" method="get" id="details_form">
        <input type="hidden" name="ticket_id" value="<?php echo $_SESSION['data']['ticket_id'] ?>">
    </form>
</div>


<?php
require('shared/closing_tags.php');
require('../control/shared/clean_session.inc.php');
?>


<script>
    set_active_link("my_tickets")
</script>