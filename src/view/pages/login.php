<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // User already logged in -> Go to dashboard
    header('location: dashboard.php');
    exit();
}
?>
<?php require('page_frame/ui_frame.php'); ?>

<div class="main">
    <div class="login">
        <div class="card">
            <div class="w3-container card-head w3-center">
                <h3>Sign In</h3>
            </div>
            <div class="w3-container">
                <p class="error"><?php echo $_SESSION['errors']['login_error'] ?? '' ?>
                </p>
            </div>
            <form action="../../control/login.inc.php" method="POST" class="w3-container" id="login_form">
                <p>
                    <input type="text" name="email" class="w3-input" value="<?php echo $_SESSION['post_data']['email'] ?? '' ?>">
                    <label>Email</label>
                </p>
                <p class="error"><?php echo $_SESSION['errors']['email'] ?? '' ?>
                </p>
                <p>
                    <input type="text" name="pwd" class="w3-input">
                    <label>Password</label>
                </p>
                <p class="error">
                    <?php echo $_SESSION['errors']['pwd'] ?? '' ?>
                </p>
            </form>
        </div>
        <div class="row">
            <div class="col">
                <div class="w3-container w3-center">
                    <input type="submit" value=" SIGN IN " name="login_submit" class="btn-primary" form="login_form" style="margin-bottom:2em;">
                </div>
                <p>Create an account? <a href="signup.php">Sign Up</a></p>
                <p>Sign in as <a href="demo_login.php">Demo User</a></p>
            </div>
        </div>
    </div>
</div>

<?php
require('page_frame/closing_tags.php');
?>