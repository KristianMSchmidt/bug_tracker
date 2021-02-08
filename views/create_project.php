<?php
include('../includes/login_check.inc.php');
if (isset($_POST['submit'])) {
    include('../classes/form_handlers/CreateProjectHandler.class.php');
    $create_project_handler = new CreateProjectHandler($_POST);
    $create_project_handler->process_input();
}
include('shared/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="edit_ticket">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Create Project</h3>
                </div>
                <div class="w3-container">
                    <form action="create_project.php" method="POST">
                        <!-- Title -->
                        <p>
                            <input type="text" name="title" maxlength="30" class="w3-input title" value="<?php echo $_SESSION['post_data']['title'] ?? '' ?>">
                            <label>Project Title</label><br>

                            <span class="error">
                                <?php echo $_SESSION['errors']['title'] ?? '' ?>
                            </span>
                        </p>
                        <!-- Description -->
                        <p>
                            <input type="text" name="description" maxlength="200" class="w3-input" value="<?php echo $_SESSION['post_data']['description'] ?? '' ?>">
                            <label>Description</label><br>
                            <span class=" error">
                                <?php echo $_SESSION['errors']['description'] ?? '' ?>
                            </span>
                        </p>

                        <!-- Submitter -->
                        <input type="hidden" name="created_by" value="<?php echo $_SESSION['user_id'] ?>">

                        <!-- Submit button -->
                        <div class="w3-container w3-center">
                            <input type="submit" name="submit" class="btn-primary" value="Create Project">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="main">Only administrators and project managers have acces to this page. </div>
    <?php endif ?>
</div>

<?
if (isset($_SESSION['post_data'])) {
    unset($_SESSION['post_data']);
}
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>

<?php include('shared/closing_tags.php'); ?>
<script>
    set_active_link("manage_project_users");
</script>