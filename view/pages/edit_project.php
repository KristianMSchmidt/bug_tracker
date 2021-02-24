<?php
require('../../control/shared/login_check.inc.php');
require_once('../../control/controller.class.php');
$contr = new Controller();

if (isset($_GET['show_original'])) {
    $project_id = $_GET['project_id'];
    $_SESSION['data'] = $contr->get_project_by_id($project_id, -1);
}
if (!isset($_SESSION['data']['project_id'])) {
    header("location: my_projects.php");
}
$project_details_permission = $contr->check_project_details_permission($_SESSION['user_id'], $_SESSION['role_name'], $_SESSION['data']['project_id']);

require('page_frame/ui_frame.php');
?>

<div class="main">
    <!-- All admins have acces. PM's with project details permission also have access -->
    <?php if ($project_details_permission && (in_array($_SESSION['role_name'], ['Admin', 'Project Manager']))) : ?>
        <div class="edit_project">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Edit Project</h3>
                    <a href="project_details.php?project_id=<?php echo $_SESSION['data']['project_id'] ?>"> Project Details</a>
                </div>

                <div class="card-content">
                    <form action="../../control/edit_project.inc.php" method="POST" class="w3-container" id="edit_project_form">

                        <!-- Title -->
                        <div class="left">
                            <p>
                                <input type="text" name="project_name" maxlength="30" class="w3-input title" value="<?php echo $_SESSION['data']['project_name'] ?? '' ?>">
                                <label>Project Name</label><br>
                                <span class="error">
                                    <?php echo $_SESSION['errors']['title'] ?? '' ?>
                                </span>
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="right">
                            <p>
                                <input type="text" name="project_description" maxlength="200" class="w3-input" value="<?php echo $_SESSION['data']['project_description'] ?? '' ?>">
                                <label>Project Description</label><br>
                                <span class="error">
                                    <?php echo $_SESSION['errors']['description'] ?? '' ?>
                                </span>
                            </p>
                        </div>

                        <!-- Hidden input -->
                        <input type="hidden" name="project_id" value="<?php echo $_SESSION['data']['project_id'] ?>">
                    </form>
                    <p class="error w3-center">
                        <?php echo $_SESSION['errors']['no_changes_error'] ?? '' ?>
                    </p>
                </div>
            </div>
            <!-- Submit button -->
            <div class="w3-container w3-center">
                <input type="submit" name="submit" class="btn-primary below-card" value="Make Changes" form="edit_project_form">
            </div>
        </div>
    <?php else : ?>
        <p>You don't have permission to edit this ticket. Please contact your local administrator.</p>
    <?php endif ?>
</div>


<?php
require('page_frame/closing_tags.php');
?>
<script>
    set_active_link("my_projects");
</script>