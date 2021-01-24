<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$projects = $contr->get_projects_by_user_id($_SESSION['user_id'], $_SESSION['role_name']);
?>

<div class="main">

    <div class="my_projects">

        <form action="create_project.php">
            <input type="submit" value="CREATE NEW PROJECT" class="btn-primary large">
        </form>

        <div class="card">
            <div class="container card-head">
                <h2>My projects</h2>
            </div>
            <div class="container">
                <p>
                    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                        Administrators see all projects in the database
                    <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                        Project Managers see all projects they are assigned to
                    <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                        Developers see all projects they are assigned to
                    <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                        Submitters see all projects they are assigned to
                    <?php endif ?>
                </p>
                <div class="container w3-responsive">
                    <table class="table striped bordered">
                        <tr>
                            <th>Project Name</th>
                            <th>Description</th>
                            <th style="width:130px;"></th>
                        </tr>
                        <?php if (count($projects) == 0) : ?>
                    </table>
                    <div class="empty-table-row">
                        <p>You have no projects in the database</p>
                    </div>
                </div>
                <p>Showing 0-0 of 0 entries</p>
            </div>
        <?php else : ?>


            <?php foreach ($projects as $project) : ?>
                <form action="project_details.php" method="post" id="project_details_form_<?php echo $project['project_id'] ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project['project_id'] ?>">
                </form>

                <tr>
                    <td><?php echo $project['project_name'] ?></td>
                    <td style="padding-right:2em;"><?php echo $project['project_description'] ?></td>
                    <td>
                        <ul style="padding:0; margin:0;">
                            <li> <a href="#">Manage Users</a></li>
                            <li> <a href="#" onclick="document.getElementById('project_details_form_<?php echo $project['project_id'] ?>').submit()">
                                    Details
                                </a></li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach ?>
            </table>
        </div>
        <p>Showing project 1-<?php echo count($projects); ?> out of <?php echo count($projects); ?>.</p>
    </div>
<?php endif ?>

</div>
</div>
</div>


<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>