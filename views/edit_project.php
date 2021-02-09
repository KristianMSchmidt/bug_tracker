<?php
include('../includes/shared/login_check.inc.php');
include_once('../includes/shared/auto_loader.inc.php');

if (isset($_GET['show_original'])) {
    $contr = new Controller();
    $project_id = $_GET['project_id'];
    $_SESSION['data'] = $contr->get_project_by_id($project_id);
}
include('shared/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="edit_ticket">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Edit Project</h3>
                    <a href="project_details.php?project_id=<?php echo $_SESSION['data']['project_id'] ?>"> Project Details</a>
                </div>

                <div class="card-content">
                    <form action="../includes/edit_project.inc.php" method="POST" class="w3-container">

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


                        <p class="error w3-center">
                            <?php echo $_SESSION['errors']['no_changes_error'] ?? '' ?>
                        </p>

                        <!-- Submit button -->
                        <div class="w3-container w3-center">
                            <input type="submit" name="submit" class="btn-primary" value="Make Changes">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="main">Only administrators and project managers have acces to this page. </div>
    <?php endif ?>
</div>


<?php
include('../includes/shared/clean_session.inc.php');
include('shared/closing_tags.php');
?>
<script>
    set_active_link("my_projects");
</script>

<?php
include('../includes/shared/clean_session.inc.php');
?>