<?php
require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');

$contr = new controller;
$projects = $contr->get_projects_by_user($_SESSION['user_id'], $_SESSION['role_name']);
?>

<div class="main">
    <div class="my_projects">
        <div class="wrapper">
            <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
                <form action="create_project.php" method="get">
                    <input type="submit" value="CREATE NEW PROJECT" class="btn-primary">
                </form>
            <?php endif ?>
            <div class="card w3-responsive">
                <div class="w3-container card-head">
                    <h3>My Projects</h3>
                </div>
                <div class="w3-container">
                    <p>
                        <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                            All projects in the database
                        <?php else : ?>
                            All your projects in the database
                        <?php endif ?>
                    </p>
                </div>
                <div class="w3-container w3-responsive">
                    <table class="w3-table w3-small w3-striped w3-bordered">
                        <tr>
                            <th>Project Name</th>
                            <th class="hide_if_needed">Created By</th>
                            <th class="hide_if_needed"> Created</th>
                            <th>Last Update</th>
                            <th>Enrollled since</th>
                            <th>Project Details</th>
                        </tr>
                        <?php
                        ?>
                        <?php foreach ($projects as $project) : ?>
                            <?php $enrolled_since = $contr->get_enrollment_start_by_user_and_project($project['project_id'], $_SESSION['user_id']); ?>
                            <tr>
                                <td><?php echo $project['project_name'] ?></td>
                                <td class="hide_if_needed"><?php echo $project['created_by'] ?></td>
                                <td class="hide_if_needed"><?php echo $project['created_at'] ?></th>
                                <td><?php echo $project['updated_at'] ?></td>
                                <td><?php echo $enrolled_since ?></td>
                                <td>
                                    <a href="project_details.php?project_id=<?php echo $project['project_id'] ?>">Details</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                    <?php if (count($projects) == 0) : ?>
                        <div class="empty-table-row">
                            <p>You have no projects in the database</p>
                        </div>
                        <p class="entry-info">Showing 0-0 of 0 entries</p>
                    <?php else : ?>
                        <p class="entry-info">Showing 1-<?php echo count($projects); ?> of <?php echo count($projects); ?> entries</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (isset($_SESSION['create_project_succes'])) : ?>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container" style="padding-bottom:3em;">
                    <h5>
                        You succesfully created the following project:
                    </h5>
                    <div class="w3-container w3-responsive">
                        <table class="w3-table w3-striped w3-bordered">
                            <tr>
                                <th>Project</th>
                                <th>Description</th>
                            </tr>
                            <tr>
                                <td><?php echo $_SESSION['data']['project_name'] ?></td>
                                <td><?php echo $_SESSION['data']['project_description'] ?></td>
                            </tr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id01').style.display = 'block';
    </script>
<?php endif ?>
<?php require('page_frame/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>