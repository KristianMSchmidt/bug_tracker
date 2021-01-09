<?php
require 'templates/ui_frame.php';

if (!$_SESSION['role'] == '2') {
    header('Location: login.php');
    exit();
}

//Only admins will see the following

include('includes/db_connect.inc.php');

// write query for all projects
$sql = 'SELECT * FROM projects';

// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<div class="main">

    <h3> All projects </h3>
    <p> Search project___</p>
    <table style="width:100%">
        <tr>
            <th>project name</th>
            <th>description</th>
        </tr>

        <?php foreach ($projects as $project) : ?>
            <tr>
                <td><?php echo $project['project_name'] ?></td>
                <td><?php echo $project['project_description'] ?></td>
                <td><a href="show_project_details.php?id= <?php echo $project['id'] ?>">More Details</a></td>
                </td>


            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    // free result from memory (good practice)
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);
    ?>
    <br>
    <form action="add_project.php">
        <input type="submit" value="add project"><br>
    </form>

</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>