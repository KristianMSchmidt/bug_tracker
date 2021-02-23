<?php
require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');

$contr = new controller;

// Get details of all relevant projects for the user in question 
$projects = $contr->get_user_projects_details($_SESSION['user_id'], $_SESSION['role_name'], $_GET['order'], $_GET['dir']);
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

                <script>
                    let order_direction = "<?php echo $_GET['dir']; ?>";

                    function reorder(order_by) {
                        var url = "my_projects.php?order=" + order_by + "&dir=";
                        if (order_direction == "asc") {
                            window.location.href = "my_projects.php?order=" + order_by + "&dir=desc";
                        } else {
                            window.location.href = "my_projects.php?order=" + order_by + "&dir=asc";
                        }
                    }
                </script>
                <div class="w3-container w3-responsive">
                    <table class="w3-table w3-small w3-striped w3-bordered">
                        <tr>
                            <th><a href="#" onclick="reorder('project_name')">Project Name</a></th>
                            <th class="hide_if_needed"><a href="#" onclick="reorder('created_by')">Created By</a></th>
                            <th class="hide_if_needed"><a href="#" onclick="reorder('created_at')"> Created</a></th>
                            <th><a href="#" onclick="reorder('updated_at')">Last Update</a></th>
                            <th><a href="#" onclick="reorder('enrollment_start')">Enrollled since</a></th>
                            <th>Project Details</th>
                        </tr>
                        <?php
                        ?>
                        <?php foreach ($projects as $project) : ?>
                            <tr>
                                <td><?php echo $project['project_name'] ?></td>
                                <td class="hide_if_needed"><?php echo $project['created_by'] ?></td>
                                <td class="hide_if_needed"><?php echo $project['created_at'] ?></th>
                                <td><?php echo $project['updated_at'] ?></td>
                                <?php if (isset($project['enrollment_start'])) : ?>
                                    <td><?php echo $project['enrollment_start'] ?></td>
                                <?php else : ?>
                                    <td>Not enrolled</td>
                                <?php endif ?>
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

<?php require('page_frame/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>