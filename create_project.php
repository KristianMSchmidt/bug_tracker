<?php
require "templates/ui_frame.php";
?>

<div class="main" style="margin-left:4em; margin-right:4em;">

    <h2>Create project</h2>
    <?php

    $title = $description = "";

    if (isset($_GET['createprojectsucces'])) {
        echo '<p class="loginsucces">Your project was added to the database</p>';
    }

    if (isset($_GET['error'])) {
        //user has tried to create a new project but there is an error     
        //recover title and description
        $title = htmlspecialchars($_GET['title']);
        $description = htmlspecialchars($_GET['description']);
        if ($_GET['error'] == 'notitle') {
            echo '<p class="loginerror">Your project needs a title</p>';
        } elseif ($_GET['error'] == 'nodescription') {
            echo '<p class="loginerror">Your project needs a description</p>';
        } elseif ($_GET['error'] == 'titleexists') {
            echo '<p class="loginerror">There is already a project with that title in the database</p>';
        }
    }
    ?>


    <form action="includes/create_project.inc.php" method="POST">
        <input type="text" name="title" placeholder="Project title" value="<?php echo $title ?>"><br><br>
        <textarea rows="4" cols="50" name="description" placeholder="Describe your project..."><?php echo $description ?></textarea><br>
        <input type="submit" value="Create project" class="signin_button">
        <input type="hidden" name="create_project_submit">
    </form>

</div> <!-- div.main -->
</div> <!-- div.wrapper-->
</body>

</html>