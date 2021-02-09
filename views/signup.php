<?php

if (isset($_POST['signup_submit'])) {
    include_once('../includes/shared/auto_loader.inc.php');
    include('../classes/form_handlers/SignupHandler.class.php');
    $signup_handler = new SignUpHandler($_POST);
    $feedback = $signup_handler->process_input();

    if ($feedback['signup_succes']) {
        header('location:dashboard.php');
        exit();
    }
}
?>


<?php include('shared/ui_frame.php'); ?>

<div class="main">
    <div class="login">
        <div class="card">

            <div class="w3-container card-head w3-center">
                <h3>Sign up</h3>
            </div>
            <div class="w3-container">
                <p class="error"><?php echo $feedback['signup_error'] ?? '' ?>
                </p>
            </div>


            <form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container">
                <p>
                    <input type="text" name="full_name" class="w3-input" value="<?php echo $_POST['full_name'] ?? '' ?>">
                    <label>Full name</label>
                </p>
                <p class="error"><?php echo $feedback['input_errors']['full_name'] ?? '' ?>

                <p>
                    <input type="text" name="email" class="w3-input" value="<?php echo $_POST['email'] ?? '' ?>">
                    <label>Email</label>
                </p>
                <p class="error">
                    <?php echo $feedback['input_errors']['email'] ?? '' ?>
                </p>

                <p>
                    <input type="text" name="pwd" class="w3-input" value="">
                    <label>Password</label>
                </p>
                <p class="error">
                    <?php echo $feedback['input_errors']['pwd'] ?? '' ?>
                </p>

                <p>
                    <input type="text" name="pwd_repeat" class="w3-input" value="">
                    <label>Repeat password</label>
                </p>
                <p class="error">
                    <?php echo $feedback['input_errors']['pwd_repeat'] ?? '' ?>
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
<?php include('shared/closing_tags.php') ?>