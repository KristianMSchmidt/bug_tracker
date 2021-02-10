<?php
include_once('../control/shared/login_check.inc.php');
include_once('shared/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="edit_ticket">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Create Project</h3>
                </div>
                <div class="w3-container">
                    <form action="../control/create_project.inc.php" method="POST">
                        <!-- Title -->
                        <p>
                            <input type="text" name="project_name" maxlength="30" class="w3-input title" value="<?php echo $_SESSION['data']['project_name'] ?? '' ?>">
                            <label>Project Title</label><br>

                            <span class="error">
                                <?php echo $_SESSION['errors']['title'] ?? '' ?>
                            </span>
                        </p>
                        <!-- Description -->
                        <p>
                            <input type="text" name="project_description" maxlength="200" class="w3-input" value="<?php echo $_SESSION['data']['project_description'] ?? '' ?>">
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

<?php
include_once('../control/shared/clean_session.inc.php');
include_once('shared/closing_tags.php');
?>
<script>
    set_active_link("my_projects");
</script>