<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$projects = $contr->get_projects_by_user_id($_SESSION['user_id'], $_SESSION['role_name']);
?>

<div class="main">

    <div class="my_projects">

        <form action="create_project.php" method="POST">
            <input type="submit" name="submit" value="CREATE NEW PROJECT" class="btn-primary large">
        </form>

        <div class="card">
            <div class="container card-head">
                <h2>My projects</h2>
            </div>
            <div class="container">
                <h4>
                    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                        All projects in your database
                    <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                        All projects you are assigned to
                    <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                        All projects you are assighed to
                    <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                        All projects your are assigned to
                    <?php endif ?>
                </h4>
                <div class="container w3-responsive">
                    <table class="table w3-small striped bordered">
                        <tr>
                            <th>Project Name</th>
                            <th>Description</th>
                            <th style="width:130px;"></th>
                        </tr>
                        <?php
                        //$projects = array();
                        ?>
                        <?php foreach ($projects as $project) : ?>
                            <tr>
                                <td><?php echo $project['project_name'] ?></td>
                                <td style="padding-right:2em;"><?php echo $project['project_description'] ?></td>
                                <td>
                                    <a href="#" onclick="details_submitter(<?php echo $project['project_id'] ?>)">Details</a>                                    
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                <?php if (count($projects) == 0) : ?>
                    <div class="empty-table-row">
                        <p>You have no projects in the database</p>
                    </div>
                    <p style="font-size:12px">Showing 0-0 of 0 entries</p>
                <?php else : ?>
                    <p style="font-size:12px">Showing 1-<?php echo count($projects); ?> of <?php echo count($projects); ?> entries</p>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<form action="project_details.php" method="post" id="form">
    <input type="hidden" name="project_id" id="project_id" value="">
</form>

<script>
    function details_submitter(project_id) {
        document.getElementById("project_id").value = project_id;
        document.getElementById("form").submit();
    }
</script>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>