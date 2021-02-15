<?php
require('../control/shared/login_check.inc.php');
require('../control/shared/check_project_permission.inc.php');
require_once('../control/controller.class.php');
$contr = new Controller();

if (isset($_GET['show_original'])) {
    $project_id = $_GET['project_id'];
    $_SESSION['data'] = $contr->get_project_by_id($project_id);
}
if (!isset($_SESSION['data']['project_id'])) {
    header("location: my_projects.php");
}
$project_permission = check_project_permission($contr, $_SESSION['user_id'], $_SESSION['data']['project_id']);

require('page_frame/ui_frame.php');
?>

<div class="main">
    <!-- All admins have acces. PM's enrolled in this project also have acces -->
    <?php if ($_SESSION['role_name'] == 'Admin' || (($_SESSION['role_name'] == 'Project Manager') && $ticket_permission)) : ?>
        <div class="edit_project">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Edit Project</h3>
                    <a href="project_details.php?project_id=<?php echo $_SESSION['data']['project_id'] ?>"> Project Details</a>
                </div>

                <div class="card-content">
                    <form action="../control/edit_project.inc.php" method="POST" class="w3-container" id="edit_project_form">

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
                </div>
            </div>
            <br>
            <p class="error w3-center">
                <?php echo $_SESSION['errors']['no_changes_error'] ?? '' ?>
            </p>
            <!-- Submit button -->
            <div class="w3-container w3-center">
                <input type="submit" name="submit" class="btn-primary below-card" value="Make Changes" form="edit_project_form">
            </div>
        </div>
    <?php else : ?>
        <div class="main">Only administrators and project managers have acces to this page. </div>
    <?php endif ?>
</div>


<?php
require('../control/shared/clean_session.inc.php');
require('page_frame/closing_tags.php');
?>
<script>
    set_active_link("my_projects");
</script>