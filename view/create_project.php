<?php
require('../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="create_project">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Create Project</h3>
                </div>
                <div class="w3-container">
                    <form action="../control/create_project.inc.php" method="POST" id="create_project_form">
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
                    </form>
                </div>
            </div>
            <br>
            <br>
            <!-- Submit button -->
            <div class="w3-container w3-center">
                <input type="submit" name="submit" class="btn-primary" value="Create Project" form="create_project_form">
            </div>
        </div>
    <?php else : ?>
        <p>You don't have acces to this page. Please contact your local administrator or project manager.</p>
    <?php endif ?>
</div>

<?php
require('../control/shared/clean_session.inc.php');
require('page_frame/closing_tags.php');
?>
<script>
    set_active_link("my_projects");
</script>