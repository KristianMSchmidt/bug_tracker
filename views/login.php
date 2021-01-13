<?php

session_start();

if (isset($_SESSION['username'])) {
    header('location: dashboard.php');
    exit();
}

include_once('../includes/auto_loader.inc.php');

if (isset($_POST['login_submit'])) {
    $login_handler = new LoginHandler($_POST);
    $feedback = $login_handler->process_input();
    if ($feedback['login_succes']) {
        header('location:dashboard.php');
        exit();
    }
}
?>

<?php include('shared/ui_frame.php'); ?>

<div class="main">
    <h2>Login</h2>

    <?php echo $feedback['login_error'] ?? '' ?>

    <form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <label>Username: </label>
        <input type="text" name="username" value="<?php echo $_POST['username'] ?? '' ?>">
        <div class="error">
            <?php echo $feedback['input_errors']['username'] ?? '' ?>
        </div>
        <label>Password: </label>
        <input type="text" name="pwd" value="">
        <div class="error">
            <?php echo $feedback['input_errors']['pwd'] ?? '' ?>
        </div>
        <input type="submit" value="submit" name="login_submit">
    </form>
    <div>
        <p>Create an account? <a href="signup.php">Sign Up</a></p>
        <p>Sign in as a <a href="demo_login.php">Demo User</a></p>
    </div>
</div>
<?php include('shared/closing_tags.php') ?>