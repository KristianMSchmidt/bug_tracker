<?php
include('../includes/shared/login_check.inc.php');
include_once('../includes/shared/auto_loader.inc.php');
$contr = new Controller();
$projects = $contr->get_projects();
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();
$developers = $contr->get_users_by_role_id(3);

if (isset($_GET['project_id'])) {
    $_SESSION['data']['project_name'] = $contr->get_project_name_by_id($_GET['project_id'])['project_name'];
    $_SESSION['data']['project_id'] = $_GET['project_id'];
}
include('shared/ui_frame.php');
?>


<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
        <div class="edit_ticket">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Create Ticket</h3>
                </div>
                <div class="card-content">
                    <form action="../includes/create_ticket.inc.php" method="POST" class="w3-container">
                        <div class="text-input">
                            <div class="left">
                                <!-- Title -->
                                <p>
                                    <input type="text" name="title" maxlength="30" class="w3-input title" value="<?php echo $_SESSION['data']['title'] ?? ''; ?>">
                                    <label>Ticket Title</label><br>
                                    <span class="error">
                                        <?php echo $_SESSION['errors']['title'] ?? '' ?>
                                    </span>
                                </p>
                            </div>
                            <div class="right">
                                <!-- Description -->
                                <p>
                                    <input type="text" name="description" class="w3-input" value="<?php echo $_SESSION['data']['description'] ?? '' ?>">
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
                                    <option value="" disabled selected>Choose Project</option>
                                    <?php foreach ($projects as $project) : ?>
                                        <option value="<?php echo $project['project_id'] ?>" <?php if (isset($_SESSION['data']['project_id'])) : ?> <?php if ($_SESSION['data']['project_id'] == $project['project_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $project['project_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['project'] ?? '' ?></p>
                                <label>Project</label>

                                <!-- Ticket Priority -->
                                <select class="w3-select" name="priority_id">
                                    <option value="" disabled selected>Choose Priority</option>
                                    <?php foreach ($priorities as $priority) : ?>
                                        <option value="<?php echo $priority['ticket_priority_id'] ?>" <?php if (isset($_SESSION['data']['priority_id'])) : ?> <?php if ($_SESSION['data']['priority_id'] == $priority['ticket_priority_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $priority['ticket_priority_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['priority'] ?? '' ?></p>
                                <label>Ticket Priority</label>

                                <!-- Ticket Type -->
                                <select class="w3-select" name="type_id">
                                    <option value="" disabled selected>Choose Ticket Type</option>
                                    <?php foreach ($types as $type) : ?>
                                        <option value="<?php echo $type['ticket_type_id'] ?>" <?php if (isset($_SESSION['data']['type_id'])) : ?> <?php if ($_SESSION['data']['type_id'] == $type['ticket_type_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $type['ticket_type_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['type'] ?? '' ?></p>
                                <label>Ticket Type</label>
                            </div>
                            <div class="right">
                                <!-- Developer Assigned -->
                                <select class="w3-select" name="developer_assigned">
                                    <option value="" disabled selected>Choose Developer</option>
                                    <?php foreach ($developers as $developer) : ?>
                                        <option value="<?php echo $developer['user_id'] ?>" <?php if (isset($_SESSION['data']['developer_assigned'])) : ?> <?php if ($_SESSION['data']['developer_assigned'] == $developer['user_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $developer['full_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['developer'] ?? '' ?></p>
                                <label>Developer Assigned</label>

                                <!-- Ticket Status -->
                                <select class="w3-select" name="status_id">
                                    <option value="" disabled selected>Choose Ticket Status</option>
                                    <?php foreach ($status_types as $status_type) : ?>
                                        <option value="<?php echo $status_type['ticket_status_id'] ?>" <?php if (isset($_SESSION['data']['status_id'])) : ?> <?php if ($_SESSION['data']['status_id'] == $status_type['ticket_status_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $status_type['ticket_status_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['status'] ?? '' ?></p>
                                <label>Ticket Status</label>

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
    <?php else : ?>
        <div class="main">Developers don't have acces to this page</div>
    <?php endif ?>
</div>


<?php
include('../includes/shared/clean_session.inc.php');
include('shared/closing_tags.php')
?>

<script>
    set_active_link("my_tickets")
</script>