<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include_once('../includes/auto_loader.inc.php');
$contr = new Controller();
$ticket = $contr->get_ticket_by_id($_POST['ticket_id']);

if ($_POST['requested_action'] == "edit_ticket_attempt") {
    include('../classes/form_handlers/EditTicketHandler.class.php');
    $edit_ticket_handler = new EditTicketHandler($ticket, $_POST);
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
            </div>

            <div class="card-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container">
                    <div class="text-input">
                        <div class="left">
                            <!-- Title -->
                            <p>
                                <input type="text" name="title" class="w3-input" value="<?php echo $ticket['title'] ?? '' ?>">
                                <label>Ticket Title</label><br>
                                <span class="error">
                                    <?php echo $errors['title'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                        <div class="right">
                            <!-- Description -->
                            <p>
                                <input type="text" name="description" class="w3-input" value="<?php echo $ticket['description'] ?? '' ?>">
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
                            <select class="select" name="project">
                                <option value="<?php echo $ticket['project'] ?>" selected><?php echo $ticket['project_name']; ?></option>
                                <?php foreach ($projects as $project) : ?>
                                    <?php if ($project['project_id'] != $ticket['project']) : ?>
                                        <option value=<?php echo $project['project_id'] ?>><?php echo $project['project_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Project</label>

                            <!-- Ticket Priority -->
                            <select class="select" name="priority">
                                <option value=<?php echo $ticket['priority'] ?> selected><?php echo $ticket['ticket_priority_name']; ?></option>
                                <?php foreach ($priorities as $priority) : ?>
                                    <?php if ($priority['ticket_priority_id'] != $ticket['priority']) : ?>
                                        <option value=<?php echo $priority['ticket_priority_id'] ?>><?php echo $priority['ticket_priority_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Priority</label>

                            <!-- Ticket Type -->
                            <select class="select" name="type">
                                <option value=<?php echo $ticket['type'] ?> selected><?php echo $ticket['ticket_type_name'] ?></option>
                                <?php foreach ($types as $type) : ?>
                                    <?php if ($type['ticket_type_id'] != $ticket['type']) : ?>
                                        <option value=<?php echo $type['ticket_type_id'] ?>><?php echo $type['ticket_type_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Type</label>
                        </div>
                        <div class="right">

                            <!-- Developer Assigned -->
                            <select class="select" name="developer_assigned">
                                <option value=<?php echo $ticket['developer_assigned'] ?> selected><?php echo $ticket['developer_name'] ?></option>
                                <?php foreach ($developers as $developer) : ?>
                                    <?php if ($developer['user_id'] != $ticket['developer_assigned']) : ?>
                                        <option value=<?php echo $developer['user_id'] ?>><?php echo $developer['full_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Assigned Developer</label>

                            <!-- Ticket Status -->
                            <select class="select" name="status">
                                <option value=<?php echo $ticket['status'] ?> selected><?php echo $ticket['ticket_status_name'] ?></option>
                                <?php foreach ($status_types as $status_type) : ?>
                                    <?php if ($status_type['ticket_status_id'] != $ticket['status']) : ?>
                                        <option value=<?php echo $status_type['ticket_status_id'] ?>><?php echo $status_type['ticket_status_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Status</label>

                            <!-- Ticet Id -->
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">

                            <!-- Requested action -->
                            <input type="hidden" name="requested_action" value="edit_ticket_attempt">

                            <p class="error w3-center">
                                <?php echo $errors['no_changes_error'] ?? '' ?>
                            </p>
                            <!-- Submit button -->
                            <div class="w3-container w3-center">
                                <input type="submit" class="btn-primary" value="Make Changes">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('shared/closing_tags.php') ?>


<script>
    set_active_link("my_tickets")
</script>