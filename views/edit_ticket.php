<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');

/* 'old' refers to values currently stored in the database */
/* 'new' is what is to be shown in form ' */

include_once('../includes/auto_loader.inc.php');
$contr = new Controller();
$old_ticket = $contr->get_ticket_by_id($_POST['ticket_id']);

if (isset($_POST['go_to_edit_ticket'])) {
    $new_ticket = $old_ticket;
} else if (isset($_POST['edit_submit'])) {
    include('../classes/form_handlers/EditTicketHandler.class.php');
    $new_ticket = array(
        'ticket_id' => $_POST['ticket_id'],
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'type_id' => $_POST['type_id'],
        'status_id' => $_POST['status_id'],
        'priority_id' => $_POST['priority_id'],
        'project_id' => $_POST['project_id'],
        'developer_assigned' => $_POST['developer_assigned']
    );
}
$new_ticket['project_name'] = $contr->get_project_name_by_id($new_ticket['project_id'])['project_name'];
$new_ticket['ticket_priority_name'] = $contr->get_priority_name_by_id($new_ticket['priority_id'])['ticket_priority_name'];
$new_ticket['ticket_type_name'] = $contr->get_ticket_type_name_by_id($new_ticket['type_id'])['ticket_type_name'];
$new_ticket['ticket_status_name'] = $contr->get_ticket_status_name_by_id($new_ticket['status_id'])['ticket_status_name'];
$new_ticket['developer_name'] = $contr->get_user_by_id($new_ticket['developer_assigned'])['full_name'];

if (isset($_POST['edit_submit'])) {
    $edit_ticket_handler = new EditTicketHandler(
        array(
            'new_ticket' => $new_ticket,
            'old_ticket' => $old_ticket
        )
    );
    $errors = $edit_ticket_handler->process_input();
}

$projects = $contr->get_projects();
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();
$developers = $contr->get_users_by_role_id(3);

include('shared/ui_frame.php');
?>
<div class="main">
    <div class="edit_ticket">
        <div class="card">
            <div class="w3-container card-head">
                <h2>Edit Ticket</h2>
                <a href="#" onclick="document.getElementById('details_form').submit()">Ticket Details</a>
            </div>
            <div class="card-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container">
                    <div class="text-input">
                        <div class="left">
                            <!-- Title -->
                            <p>
                                <input type="text" name="title" class="w3-input title" maxlength="30" value="<?php echo $new_ticket['title'] ?? '' ?>">
                                <label>Ticket Title</label><br>
                                <span class="error">
                                    <?php echo $errors['title'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                        <div class="right">
                            <!-- Description -->
                            <p>
                                <input type="text" name="description" class="w3-input" maxlength="200" value="<?php echo $new_ticket['description'] ?? '' ?>">
                                <label>Description</label><br>
                                <span class="error">
                                    <?php echo $errors['description'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="other-input">
                        <div class="left">
                            <!-- Project -->
                            <select class="w3-select" name="project_id">
                                <option value="<?php echo $new_ticket['project_id'] ?>" selected><?php echo $new_ticket['project_name']; ?></option>
                                <?php foreach ($projects as $project) : ?>
                                    <?php if ($project['project_id'] != $new_ticket['project_id']) : ?>
                                        <option value="<?php echo $project['project_id'] ?>"><?php echo $project['project_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Project</label>

                            <!-- Ticket Priority -->
                            <select class="w3-select" name="priority_id">
                                <option value="<?php echo $new_ticket['priority_id'] ?>" selected><?php echo $new_ticket['ticket_priority_name']; ?></option>
                                <?php foreach ($priorities as $priority) : ?>
                                    <?php if ($priority['ticket_priority_id'] !== $new_ticket['priority_id']) : ?>
                                        <option value="<?php echo $priority['ticket_priority_id'] ?>"><?php echo $priority['ticket_priority_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Priority</label>

                            <!-- Ticket Type -->
                            <select class="w3-select" name="type_id">
                                <option value="<?php echo $new_ticket['type_id'] ?>" selected><?php echo $new_ticket['ticket_type_name'] ?></option>
                                <?php foreach ($types as $type) : ?>
                                    <?php if ($type['ticket_type_id'] !== $new_ticket['type_id']) : ?>
                                        <option value="<?php echo $type['ticket_type_id'] ?>"><?php echo $type['ticket_type_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Type</label>
                        </div>
                        <div class="right">

                            <!-- Developer Assigned -->
                            <select class="w3-select" name="developer_assigned">
                                <option value="<?php echo $new_ticket['developer_assigned'] ?>" selected><?php echo $new_ticket['developer_name'] ?></option>
                                <?php foreach ($developers as $developer) : ?>
                                    <?php if ($developer['user_id'] !== $new_ticket['developer_assigned']) : ?>
                                        <option value="<?php echo $developer['user_id'] ?>"><?php echo $developer['full_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Assigned Developer</label>

                            <!-- Ticket Status -->
                            <select class="w3-select" name="status_id">
                                <option value="<?php echo $new_ticket['status_id'] ?>" selected><?php echo $new_ticket['ticket_status_name'] ?></option>
                                <?php foreach ($status_types as $status_type) : ?>
                                    <?php if ($status_type['ticket_status_id'] !== $new_ticket['status_id']) : ?>
                                        <option value="<?php echo $status_type['ticket_status_id'] ?>"><?php echo $status_type['ticket_status_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Status</label>

                            <!-- Ticket Id -->
                            <input type="hidden" name="ticket_id" value="<?php echo $new_ticket['ticket_id']; ?>">

                            <!-- Error Message -->
                            <p class="error w3-center">
                                <?php echo $errors['no_changes_error'] ?? '' ?>
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
    <form action="ticket_details.php" method="post" id="details_form">
        <input type="hidden" name="ticket_id" value="<?php echo $_POST['ticket_id'] ?>">
    </form>
</div>


<?php include('shared/closing_tags.php') ?>


<script>
    set_active_link("my_tickets")
</script>