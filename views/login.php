<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // User already logged in -> Go to dashboard
    header('location: dashboard.php');
    exit();
}
?>
<?php include_once('shared/ui_frame.php'); ?>

<div class="main">
    <div class="login">
        <div class="card">
            <div class="w3-container card-head w3-center">
                <h3>Sign in</h3>
            </div>
            <div class="w3-container">
                <p class="error"><?php echo $_SESSION['errors']['login_error'] ?? '' ?>
                </p>
            </div>
            <form action="../control/login.inc.php" method="POST" class="w3-container">
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
                <div class="w3-container w3-center">
                    <input type="submit" value="Sign in" name="login_submit" class="btn-primary">
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col">
                <p>Create an account? <a href="signup.php">Sign Up</a></p>
                <p>Sign in as <a href="demo_login.php">Demo User</a></p>
            </div>
        </div>
    </div>
</div>

<?php
include_once('shared/closing_tags.php');
include_once('../control/shared/clean_session.inc.php');
?>