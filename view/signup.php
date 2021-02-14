<?php require('page_frame/ui_frame.php'); ?>

<div class="main">
    <div class="signup">
        <div class="card">

            <div class="w3-container card-head w3-center">
                <h3>Sign up</h3>
            </div>
            <div class="w3-container">
                <p class="error"><?php echo $_SESSION['signup_error'] ?? '' ?>
                </p>
            </div>

            <form action="../control/signup.inc.php" method="POST" class="w3-container">
                <p>
                    <input type="text" name="full_name" class="w3-input" value="<?php echo $_SESSION['post_data']['full_name'] ?? '' ?>">
                    <label>Full name</label>
                </p>
                <p class="error"><?php echo $_SESSION['errors']['full_name'] ?? '' ?>

                <p>
                    <input type="text" name="email" class="w3-input" value="<?php echo $_SESSION['post_data']['email'] ?? '' ?>">
                    <label>Email</label>
                </p>
                <p class="error">
                    <?php echo $_SESSION['errors']['email'] ?? '' ?>
                </p>

                <p>
                    <input type="text" name="pwd" class="w3-input" value="">
                    <label>Password</label>
                </p>
                <p class="error">
                    <?php echo $_SESSION['errors']['pwd'] ?? '' ?>
                </p>

                <p>
                    <input type="text" name="pwd_repeat" class="w3-input" value="">
                    <label>Repeat password</label>
                </p>
                <p class="error">
                    <?php echo $_SESSION['errors']['pwd_repeat'] ?? '' ?>
                </p>

                <div class="w3-container w3-center">
                    <input type="submit" value="Sign up" name="signup_submit" class="btn-primary">
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col">
                <p>Have an account? <a href="login.php">Sign in</a></p>
                <p>Sign in as <a href="demo_login.php">Demo User</a></p>
            </div>
        </div>
    </div>
</div>
<?php
require('page_frame/closing_tags.php');
require('../control/shared/clean_session.inc.php');
?>