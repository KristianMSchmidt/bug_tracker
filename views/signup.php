<?php

session_start();
session_unset();
session_destroy();
require('../includes/auto_loader.inc.php');
//require('../includes/redirect_logged_in_to_dashboard.php');

if (isset($_POST['signup_submit'])) {
    $signup_handler = new SignUpHandler($_POST);
    $feedback = $signup_handler->process_input();
    print_r($feedback);
    if ($feedback['signup_succes']) {
        header('location:dashboard.php');
        exit();
    }
}
?>

<?php include('layout/nav_bars.php'); ?>

<div class="main"">
    <h2>Sign Up</h2>
    
    <?php echo $feedback['signup_error'] ?? '' ?>

    <form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <label>Username: </label>
    <input type="text" name="username" value="<?php echo $_POST['username'] ?? '' ?>">
    <div class="error">
        <?php echo $feedback['input_errors']['username'] ?? '' ?>
    </div>

    <label>Email: </label>
    <input type="text" name="email" value="<?php echo $_POST['email'] ?? '' ?>">
    <div class="error">
        <?php echo $feedback['input_errors']['email'] ?? '' ?>
    </div>

    <label>Password: </label>
    <input type="text" name="pwd" value="">
    <div class="error">
        <?php echo $feedback['input_errors']['pwd'] ?? '' ?>
    </div>

    <label>Repeat Password: </label>
    <input type="text" name="pwd_repeat" value="">
    <div class="error">
        <?php echo $feedback['input_errors']['pwd_repeat'] ?? '' ?>
    </div>

    <input type="submit" value="submit" name="signup_submit">
    </form>

</div>
<?php include('layout/closing_tags.php') ?>