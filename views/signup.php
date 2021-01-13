<?php

if (isset($_POST['signup_submit'])) {
    include_once('../includes/auto_loader.inc.php');
    $signup_handler = new SignUpHandler($_POST);
    $feedback = $signup_handler->process_input();
    if ($feedback['signup_succes']) {
        header('location:dashboard.php');
        exit();
    }
}

include('shared/ui_frame.php');

?>

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
<?php include('shared/closing_tags.php') ?>