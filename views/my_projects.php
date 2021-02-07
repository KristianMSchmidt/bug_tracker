<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$projects = $contr->get_projects_by_user_id($_SESSION['user_id'], $_SESSION['role_name']);
?>

<div class="main">
    <div class="my_projects">
        <div class="wrapper">
            <form action="create_project.php" method="POST">
                <input type="submit" name="submit" value="CREATE NEW PROJECT" class="btn-primary large">
            </form>
            <div class="card w3-responsive">
                <div class="w3-container card-head">
                    <h3>My projects</h3>
                </div>
                <div class="w3-container">
                    <p>
                        <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                            All projects in your database
                        <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                            All projects you are assigned to
                        <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                            All projects you are assighed to
                        <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                            All projects your are assigned to
                        <?php endif ?>
                    </p>
                    <div class="w3-container">
                        <table class="table w3-small striped bordered">
                            <tr>
                                <th>Project Name</th>
                                <th>Description</th>
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
                        <p class="entry-info">Showing 0-0 of 0 entries</p>
                    <?php else : ?>
                        <p class="entry-info">Showing 1-<?php echo count($projects); ?> of <?php echo count($projects); ?> entries</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_POST['show_created_project_succes_message'])) : ?>
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <div class="w3-container">
                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <div class="w3-container">
                        <h5>
                            You succesfully created the following project:
                        </h5>
                        <div class="w3-container w3-responsive">
                            <table class="table striped bordered">
                                <tr>
                                    <th>Project</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td><?php echo $_POST['project_title'] ?></td>
                                    <td><?php echo $_POST['project_description'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('id01').style.display = 'block';
        </script>
    <?php endif ?>
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