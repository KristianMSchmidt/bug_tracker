<?php
require "templates/ui_frame.php";
if (isset($_SESSION['username'])) {
    //User is already logged in
    header('location: dashboard.php');
    exit();
}
?>

<div class="main" style="margin-left:4em; margin-right:4em;text-align:center;">
    <h2>Log in</h2>

    <?php
    if (isset($_GET['signedup'])) {
        //User has just signed succesfully up
        echo '<p class="succes">You have succesfully signed up. Now login?</p>';
    }

    if (isset($_GET['error'])) {
        //user has tried to login but there is an error     
        if ($_GET['error'] == 'emptyfields') {
            echo '<p class="error">Fill in all fields</p>';
        } else if ($_GET['error'] == 'db_error') {
            echo '<p class="error">A database error occured</p>';
        } else if ($_GET['error'] == 'invalid') {
            echo '<p class="error">Invalid username or password</p>';
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


<script>
    let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

    if (width < 850) {
        console.log("TO SMALL");
        document.getElementsByTagName("body")[0].innerHTML = "<p style='margin:5px;padding:2px'>This app is not yet ready for small screens.</p>";
    }
</script>
</body>