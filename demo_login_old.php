<?php 
    require 'templates/ui_frame.php';
?>

<div class="main demo-login">

<div style="border:5px solid black; margin:40px;">

<h2> Demo_User Login </h2>

<div style="border:1px solid black; margin-left:30%; margin-right:30%; float:left">
<form action="includes/login.inc.php" method="POST" style="float: right">  
    <a href="bt.dk" type ="submit"class="fa fa-fw fa-user fa-lg" style="color:red; display:inline-block"></a>

    <input type="hidden" name="user_login" value = "Demo_Admin"><br>
    <input type="hidden" name="password" value = "stjerne"><br>
    <input type="submit" name="login_submit" value="Admin" class="button_that_looks_like_link"><br>
</form>
</div>

<div style="border:1px solid black; margin-left:30%; margin-right:30%; float: right;">

<form action="includes/login.inc.php" method="POST">  
    <input type="hidden" name="user_login" value = "Demo_Developer"><br>
    <input type="hidden" name="password" value = "stjerne"><br>
    <input type="submit" name="login_submit" value="Developer" class="button_that_looks_like_link"><br>
</form>
</div>

<div style="border:1px solid black; margin-left:30%; margin-right:30%; float: left;">

<form action="includes/login.inc.php" method="POST">  
    <input type="hidden" name="user_login" value = "Demo_Project_Manager"><br>
    <input type="hidden" name="password" value = "stjerne"><br>
    <input type="submit" name="login_submit" value="Project Manager" class="button_that_looks_like_link"><br>
</form>
</div>


<div style="border:1px solid black; margin-left:30%; margin-right:30%; float: right;">

<form action="includes/login.inc.php" method="POST">  
    <input type="hidden" name="user_login" value = "Demo_Project_Manager"><br>
    <input type="hidden" name="password" value = "stjerne"><br>
    <input type="submit" name="login_submit" value="Submitter" class="button_that_looks_like_link"><br>
</form>
</div>
<p>Have an accout? <a href="login.php">Sign in</a>

</div>
<?php
    require 'templates/footer.php';

?>
