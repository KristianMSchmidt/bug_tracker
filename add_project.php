<?php 
    require "templates/ui_frame.php";
?>

<div class="main">
    
    <h2>Add project</h2>
    <?php
    
        if(isset($_GET['error'])){
            if($_GET['error']=='notitle'){
            echo '<p class="loginerror">Your project needs a title</p>';
            }
        }
    ?>

    <form action="includes/add_project.inc.php" method="POST">  

        <input type="text" name="title" placeholder="Project title"><br>

        <input type="text" name="description" placeholder ="Description"><br>      
        
        <input type="submit" name="add_project_submit" value="Add project"><br>
    
    </form>



<?php 
    require "templates/footer.php";
?>