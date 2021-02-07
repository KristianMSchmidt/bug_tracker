<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');

if (isset($_POST['create_project_attempt'])) {
    include('../classes/form_handlers/CreateProjectHandler.class.php');
    $create_project_handler = new CreateProjectHandler(array('new_project' => $_POST));
    $errors = $create_project_handler->process_input();
}
include('shared/ui_frame.php');
?>

<div class="main">
    <div class="edit_ticket">
        <div class="card">
            <div class="w3-container card-head">
                <h2>Create Project</h2>
            </div>
            <div class="w3-container">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <!-- Title -->
                    <p>
                        <input type="text" name="title" maxlength="30" class="w3-input title" value="<?php echo $_POST['title'] ?? '' ?>">
                        <label>Ticket Title</label><br>

                        <span class="error">
                            <?php echo $errors['title'] ?? '' ?>
                        </span>
                    </p>
                    <!-- Description -->
                    <p>
                        <input type="text" name="description" maxlength="200" class="w3-input" value="<?php echo $_POST['description'] ?? '' ?>">
                        <label>Description</label><br>
                        <span class=" error">
                            <?php echo $errors['description'] ?? '' ?>
                        </span>
                    </p>

                    <!-- Submitter -->
                    <input type="hidden" name="created_by" value="<?php echo $_SESSION['user_id'] ?>">

                    <!-- Submit button -->
                    <div class="w3-container w3-center">
                        <input type="submit" name="create_project_attempt" class="btn-primary" value="Create Project">
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