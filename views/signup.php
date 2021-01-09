<?php
require "templates/ui_frame.php";
?>


<div class="main">
    <h2>Sign Up</h2>

    <?php
    if (isset($_GET['signupsucces'])) {
        echo '<p class="text-succes">You signed up succesfully. Now you can login:</p>';
    }

    $username = $email = "";

    if (isset($_GET['error'])) {
        //user has tried to sign up but there is an error     

        //recover username and email for the lazy user
        $username = htmlspecialchars($_GET['username']);
        $email = htmlspecialchars($_GET['email']);

        if ($_GET['error'] == 'emptyfields') {
            echo '<p class="text-danger">Fill in all fields</p>';
        } else if ($_GET['error'] == 'invalidusername') {
            echo '<p class="text-danger">Invalid username</p>';
        } else if ($_GET['error'] == 'db_error') {
            echo '<p class="text-danger">A database error occured</p>';
        } else if ($_GET['error'] == 'usernametaken') {
            echo '<p class="text-danger">A user already has this username</p>';
        } else if ($_GET['error'] == 'invalidmail') {
            echo '<p class="text-danger">Invalid email</p>';
        } else if ($_GET['error'] == 'invalidpsw') {
            echo '<p class="text-danger">Password is not valid</p>';
        } else if ($_GET['error'] == 'pwsrepeat') {
            echo '<p class="text-danger">The two entered passwords were not identical</p>';
        } else if ($_GET['error'] == 'mailtaken') {
            echo '<p class="text-danger">There is already a user with this email adress</p>';
        }
    }
    ?>

    <form action="includes/signup.inc.php" method="POST">

        <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>"><br>

        <input type="text" name="email" placeholder="E-mail" value="<?php echo $email ?>"><br>

        <input type="password" name="password" placeholder="Password"><br>

        <input type="password" name="password_repeat" placeholder="Repeat password"><br><br>

        <input type="submit" name="signup_submit" value="SIGN UP"><br>

    </form>
</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>