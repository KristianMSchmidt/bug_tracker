<?php
/*
Administrators will see all projects in the database
Project Managers, Developers and Submitters will only see the projects they are assigned to
*/
require 'templates/ui_frame.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// connect to db
include('includes/db_connect.inc.php');

$sql =
    "SELECT 
    projects.project_id,
    projects.project_name,
    projects.project_description
    FROM projects";

// add conditions to sql depending on user type
if ($_SESSION['role_name'] != 'Admin') :
    $sql .= " WHERE projects.project_id IN 
              (SELECT project_id FROM project_enrollments WHERE user_id = {$_SESSION['user_id']})";
endif;

$sql .= " ORDER BY projects.created_at DESC";



// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>


<div class="main" style="margin-left:4em; margin-right:4em;">
    <br>

    <form action=" create_project.php">
        <input type="submit" value="CREATE NEW PROJECT" style="float:right" class="signin_button">
    </form>
    <br>
    <h2>Your Projects</h2>

    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
        <p>All projects in the database</p>
    <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
        <p>All the projects that you manage </p>
    <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
        <p>All the projects that you are assigned to (as developer)</p>
    <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
        <p>All the projects that you are assigned to (as submitter)</p>
    <?php endif ?>

    <table style="width:fit-content; max-width:100%;">
        <tr>
            <th>Project Name</th>
            <th>Description</th>
        </tr>

        <?php foreach ($projects as $project) : ?>
            <?php $form_id = "project_details_form_" . $project['project_id'] ?>

            <form action="show_project_details.php" method="post" id="<?php echo $form_id ?>">
                <input type="hidden" name="project_id" value="<?php echo $project['project_id'] ?> ">
                <input type="hidden" name="project_name" value="<?php echo $project['project_name'] ?> ">
                <input type="hidden" name="project_description" value="<?php echo $project['project_description'] ?> ">
            </form>

            <tr>
                <td><?php echo $project['project_name'] ?></td>
                <td><?php echo $project['project_description'] ?></td>
                <td>
                    <a href="#">Manage Users</a><br>
                    <a href="#" onclick="document.getElementById('<?php echo $form_id ?>').submit()">More Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>