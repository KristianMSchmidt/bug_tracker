<?php

session_start();

if (isset($_SESSION['user_id'])) {
    // User already logged in -> Go to dashboard
    header('location: dashboard.php');
    exit();
}

include_once('../includes/auto_loader.inc.php');
include('../classes/form_validators/loginhandler.class.php');

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
    <div class="login">
        <div class="card">

            <div class="container" style="text-align:center">
                <h3>Sign in</h3>
            </div>
            <div class="container">
                <p class="error"><?php echo $feedback['login_error'] ?? '' ?>
                </p>
            </div>
            <form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="container">
                <p>
                    <input type="text" name="email" class="input" value="<?php echo $_POST['email'] ?? '' ?>">
                    <label>Email</label>
                </p>
                <p class="error"><?php echo $feedback['input_errors']['email'] ?? '' ?>
                <p>
                <p>
                    <input type="text" name="pwd" class="input" value="<?php echo $_POST['pwd'] ?? '' ?>">
                    <label>Password</label>
                </p>
                <p class="error">
                    <?php echo $feedback['input_errors']['pwd'] ?? '' ?>
                </p>
                <div class="container" style="text-align:center">
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
<?php include('shared/closing_tags.php') ?>