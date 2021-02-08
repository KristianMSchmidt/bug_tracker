<?php
include('../includes/login_check.inc.php');
include_once('../includes/auto_loader.inc.php');

if (isset($_GET['project_id'])) {
    $contr = new Controller();
    $project_id = $_GET['project_id'];
    $_SESSION['data'] = $contr->get_project_by_id($project_id);
} else if (isset($_POST['submit'])) {
    include('../classes/form_handlers/EditProjectHandler.class.php');
    $edit_project_handler = new EditProjectHandler($_POST);
    $edit_project_handler->process_input();
}

include('shared/ui_frame.php');
?>

<div class="main">
    <div class="edit_ticket">
        <div class="card">
            <div class="w3-container card-head">
                <h3>Edit Project</h3>
                <a href="project_details.php?project_id=<?php echo $_SESSION['data']['project_id'] ?>"> Project Details</a>
            </div>

            <div class="card-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container">

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
</div>


<?php
unset($_SESSION['data']);
unset($_SESSION['errors']);
include('shared/closing_tags.php');
?>
<script>
    set_active_link("my_projects");
</script>

<?php
unset($_SESSION['edit_project_succes']);
?>