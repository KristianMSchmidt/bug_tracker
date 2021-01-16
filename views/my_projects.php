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
            <div class="container">
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
                            <th></th>
                        </tr>
                        <?php foreach ($projects as $project) : ?>

                            <tr>
                                <td><?php echo $project['project_name'] ?></td>
                                <td><?php echo $project['project_description'] ?></td>
                                <td>
                                    <a href="#" onclick="document.getElementById('<?php echo $form_id ?>').submit()">
                                        More Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                <p>Showing project 1-<?php echo count($projects); ?> out of <?php echo count($projects); ?>.</p>


            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>