<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include_once('../includes/auto_loader.inc.php');
$contr = new Controller();
$selected_project_name = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];


if ($_POST['requested_action'] == "create_ticket_attempt") {
    include('../classes/form_handlers/CreateTicketHandler.class.php');
    $create_ticket_handler = new CreateTicketHandler($_POST);
    $errors = $create_ticket_handler->process_input();
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
                <h2>Create Ticket</h2>
            </div>

            <div class="card-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container">
                    <div class="text-input">
                        <div class="left">
                            <!-- Title -->
                            <p>
                                <input type="text" name="title" class="w3-input" value="<?php echo $_POST['title'] ?? '' ?>">
                                <label>Ticket Title</label><br>
                                <span class="error">
                                    <?php echo $errors['title'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                        <div class="right">
                            <!-- Description -->
                            <p>
                                <input type="text" name="description" class="w3-input" value="<?php echo $_POST['description'] ?? '' ?>">
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
                                <option value="" disabled selected>Choose Project</option>
                                <?php foreach ($projects as $project) : ?>
                                    <option value="<?php echo $project['project_id'] ?>" <?php if ($_POST['project_id'] == $project['project_id']) : ?> selected <?php endif ?>>
                                        <?php echo $project['project_name']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <p class="error"><?php echo $errors['project'] ?? '' ?></p>
                            <label>Project</label>

                            <!-- Ticket Priority -->
                            <select class="w3-select" name="priority_id">
                                <option value="" disabled selected>Choose Priority</option>
                                <?php foreach ($priorities as $priority) : ?>
                                    <option value="<?php echo $priority['ticket_priority_id'] ?>" <?php if (isset($_POST['priority_id'])) : ?> <?php if ($_POST['priority_id'] == $priority['ticket_priority_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                        <?php echo $priority['ticket_priority_name']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <p class="error"><?php echo $errors['priority'] ?? '' ?></p>
                            <label>Ticket Priority</label>

                            <!-- Ticket Type -->
                            <select class="w3-select" name="type_id">
                                <option value="" disabled selected>Choose Ticket Type</option>
                                <?php foreach ($types as $type) : ?>
                                    <option value="<?php echo $type['ticket_type_id'] ?>" <?php if (isset($_POST['type_id'])) : ?> <?php if ($_POST['type_id'] == $type['ticket_type_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                        <?php echo $type['ticket_type_name']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <p class="error"><?php echo $errors['type'] ?? '' ?></p>
                            <label>Ticket Type</label>
                        </div>
                        <div class="right">
                            <!-- Developer Assigned -->
                            <select class="w3-select" name="developer_assigned">
                                <option value="" disabled selected>Choose Developer</option>
                                <?php foreach ($developers as $developer) : ?>
                                    <option value="<?php echo $developer['user_id'] ?>" <?php if (isset($_POST['developer_assigned'])) : ?> <?php if ($_POST['developer_assigned'] == $developer['user_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                        <?php echo $developer['full_name']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <p class="error"><?php echo $errors['developer'] ?? '' ?></p>
                            <label>Developer Assigned</label>

                            <!-- Ticket Status -->
                            <select class="w3-select" name="status_id">
                                <option value="" disabled selected>Choose Ticket Status</option>
                                <?php foreach ($status_types as $status_type) : ?>
                                    <option value="<?php echo $status_type['ticket_status_id'] ?>" <?php if (isset($_POST['status_id'])) : ?> <?php if ($_POST['status_id'] == $status_type['ticket_status_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                        <?php echo $status_type['ticket_status_name']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <p class="error"><?php echo $errors['status'] ?? '' ?></p>
                            <label>Ticket Status</label>

                            <!-- Requested action -->
                            <input type="hidden" name="requested_action" value="create_ticket_attempt">

                            <!-- Submitter -->
                            <input type="hidden" name="submitter" value="<?php echo $_SESSION['user_id'] ?>">

                            <!-- Submit button -->
                            <div class="w3-container w3-center">
                                <input type="submit" class="btn-primary" value="Create Ticket">
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