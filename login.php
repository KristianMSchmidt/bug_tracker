<?php
require "templates/ui_frame.php";
if (isset($_SESSION['username'])) {
    //User is already logged in
    header('location: dashboard.php');
    exit();
}
?>


<div class="main">
    <h2>Log in</h2>

    <?php
    if (isset($_GET['signedup'])) {
        //User has just signed succesfully up
        echo '<p class="loginsucces">You have succesfully signed up. Now login?</p>';
    }

    if (isset($_GET['error'])) {
        //user has tried to login but there is an error     
        if ($_GET['error'] == 'emptyfields') {
            echo '<p class="loginerror">Fill in all fields</p>';
        } else if ($_GET['error'] == 'db_error') {
            echo '<p class="loginerror">A database error occured</p>';
        } else if ($_GET['error'] == 'invalid') {
            echo '<p class="loginerror">Invalid username or password</p>';
        }
    }
    ?>

    <form action="includes/login.inc.php" method="POST">
        <input type="text" name="user_login" placeholder="username or email"><br>
        <input name="password" placeholder="password"><br>
        <input class="signin_button" type="submit" name="login_submit" value="SIGN IN">
    </form>


    <p>Create an account? <a href="signup.php">Sign Up</a></p>

    <p>Sign in as a <a href="demo_login.php">Demo User</a></p>
</div> <!-- div.main -->
</div> <!-- div.wrapper-->
</body>