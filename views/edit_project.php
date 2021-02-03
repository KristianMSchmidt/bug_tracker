<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');

if (isset($_POST['go_to_edit_project'])) {
    $new_project_name = $_POST['old_project_name'];
    $new_project_description = $_POST['old_project_description'];
} else if (isset($_POST['edit_submit'])) {
    include_once('../includes/auto_loader.inc.php');
    include('../classes/form_handlers/EditProjectHandler.class.php');
    $new_project_name = $_POST['new_project_name'];
    $new_project_description = $_POST['new_project_description'];
    $edit_project_handler = new EditProjectHandler($_POST);
    $errors = $edit_project_handler->process_input();
}

include('shared/ui_frame.php');
?>

<style>
    select {
        padding-top: 0.3em;
        padding-bottom: 0.3em;
    }
</style>

<div class="new_main">
    <div class="edit_ticket">
        <div class="card">
            <div class="container card-head">
                <h2>Edit Project #<?php echo $_POST['project_id'] ?></h2>
            </div>

            <div class="card-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="container">

                    <!-- Title -->
                    <div class="left">
                        <p>
                            <input type="text" name="new_project_name" class="input" value="<?php echo $new_project_name ?>">
                            <label>Project Title</label><br>
                            <span class="error">
                                <?php echo $errors['title'] ?? '' ?>
                            </span>
                        </p>
                    </div>
                    <!-- Description -->
                    <div class="right">
                        <p>
                            <input type="text" name="new_project_description" class="input" value="<?php echo $new_project_description ?>">
                            <label>Project Description</label><br>
                            <span class="error">
                                <?php echo $errors['description'] ?? '' ?>
                            </span>
                        </p>
                    </div>

                    <!-- Hidden input -->
                    <input type="hidden" name="project_id" value="<?php echo $_POST['project_id'] ?>">
                    <input type="hidden" name="old_project_name" value=<?php echo $_POST['old_project_name'] ?>>
                    <input type="hidden" name="old_project_description" value=<?php echo $_POST['old_project_description'] ?>>

                    <p class="error" style="text-align:center;">
                        <?php echo $errors['no_changes_error'] ?? '' ?>
                    </p>

                    <!-- Submit button -->
                    <div class="container" style="text-align:center">
                        <input type="submit" name="edit_submit" class="btn-primary" value="Make Changes">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<?php include('shared/closing_tags.php') ?>


<script>
    set_active_link("my_projects")
</script>