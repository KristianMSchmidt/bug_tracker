<?php
require('../../control/shared/login_check.inc.php');
require_once('../../control/controller.class.php');

if (!(isset($_GET['project_id']) && isset($_GET['project_options']))) {
    exit();
}

$contr = new Controller;

if ($_GET['project_id'] !== "none") {
    $selected_project = $contr->get_project_by_id($_GET['project_id']);
    $enrolled_developers = $contr->get_project_users($_GET['project_id'], 3);
}
if ($_GET['project_options'] == "true") {
    $projects = $contr->get_projects_by_user($_SESSION['user_id'], $_SESSION['role_name']);
}

$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();

require('page_frame/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
        <div class="create_ticket">
            <div class="wrapper">
                <?php if ($_GET['project_options'] == 'true') : ?>
                    <!-- Select Project -->
                    <div class="orto-wrapper left w3-container card non-table-card">
                        <h4 class="project">Select a project </h4>
                        <div class="w3-container">
                            <input type="text" id="search_field_project" class="search_field" placeholder="Search project" value="<?php echo $_GET['search'] ?? '' ?>">
                            <p class="small-label">
                                <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                                    All projects in the database
                                <?php else : ?>
                                    All your projects in the database
                                <?php endif ?>
                            </p>
                            <div class="scroll">
                                <?php foreach ($projects as $project) : ?>
                                    <p id="project_<?php echo $project['project_id'] ?>" class="searchable_project" onclick="choose_project(<?php echo $project['project_id'] ?>)"><?php echo $project['project_name'] ?></p>
                                <?php endforeach ?>
                                <?php if (count($projects) == 0) : ?>
                                    <p>There are no projects in the database</p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                <!-- Selected Project -->
                <div class="orto-wrapper right card ">
                    <div class="w3-container card-head">
                        <h3>
                            <?php if ($_GET['project_options'] == 'true') : ?>
                                Selected Project
                            <?php else : ?>
                                Parent Project
                            <?php endif ?>
                        </h3>
                    </div>
                    <div class="w3-container">
                        <table class="table bordered table-no-description">
                            <tr>
                                <th>Project Name</th>
                                <th>Created</th>
                                <th>Last Update</th>
                                <th>Details</th>
                            </tr>
                            <tr>
                                <?php if ($_GET['project_id'] !== 'none') : ?>
                                    <td><?php echo $selected_project['project_name']; ?></td>
                                    <td><?php echo $selected_project['created_at']; ?></td>
                                    <td><?php echo $selected_project['updated_at']; ?></td>
                                    <td> <a href="project_details.php?project_id=<?php echo $_GET['project_id'] ?>" class="right"> Project Details</a></td>
                                <?php endif ?>
                            </tr>
                        </table>
                        <?php if ($_GET['project_id'] == 'none') : ?>
                            <div class="empty-table-row">
                                <p>No selected project</p>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <?php if ($_GET['project_options'] == 'false') : ?>
                    <div class="orto-wrapper right"> </div>
                <?php endif ?>
            </div>
        </div>
        <div class="card">
            <div class="w3-container card-head">
                <h3>Create Ticket</h3>
            </div>
            <div class="card-content">
                <form action="../../control/create_ticket.inc.php" method="POST" class="w3-container" id="create_ticket_form">
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
                                <?php foreach ($enrolled_developers as $enrolled_developer) : ?>
                                    <option value="<?php echo $enrolled_developer['user_id'] ?>" <?php if (isset($_SESSION['data']['developer_assigned']) && ($_SESSION['data']['developer_assigned'] == $enrolled_developer['user_id'])) : ?> selected<?php endif ?>>
                                        <?php echo $enrolled_developer['full_name'] . " | " . $enrolled_developer['role_name']; ?> </option>
                                <?php endforeach ?>
                            </select>
                            <p class="error"><?php echo $_SESSION['errors']['developer'] ?? '' ?></p>
                            <?php if (isset($project_id)) : ?>
                                <label>Developer Assigned</label>
                            <?php else : ?>
                                <label>Developer Assigned (select a project to see options)</label>
                            <?php endif ?>

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
                        </div>

                        <!-- Project ID -->
                        <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'] ?? '' ?>" id="project_id_input">

                        <!-- Search Input -->
                        <input type="hidden" name="search_input" value="<?php echo $_GET['search_input'] ?? '' ?>" id="search_input_to_post">

                        <!-- Add to project-->
                        <input type="hidden" name="project_options" value="<?php echo $_GET['project_options'] ?>">

                        <!-- Submitter -->
                        <input type="hidden" name="submitter" value="<?php echo $_SESSION['user_id'] ?>">
                    </div>
                </form>
            </div>
        </div>
        <!-- Submit button -->
        <div class="w3-container w3-center">
            <input type="submit" class="btn-primary below-card" value="Add Ticket to Project" form="create_ticket_form">
        </div>
</div>
<?php else : ?>
    <p>You dont' have permission to this page. Please contact your local administrator or project.</p>
<?php endif ?>

<?php if ($_GET['project_options'] == "true") {
    echo "<script src='../js/create_ticket.js'></script>";
} ?>

<?php
require('page_frame/closing_tags.php');
?>

<script>
    set_active_link("my_tickets");
</script>