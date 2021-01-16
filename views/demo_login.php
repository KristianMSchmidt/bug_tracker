<?php

session_start();

if (isset($_SESSION['user_id'])) {
    // User already logged in -> Go to dashboard
    header('location: dashboard.php');
    exit();
}
?>

<?php include('shared/ui_frame.php'); ?>

<div class="main">
    <div class="demo_login">
        <div class="card">

            <div class="container" style="text-align:center">
                <h3>Demo Login</h3>
            </div>

            <div class="row">
                <div class="col one">
                    <a href="#" class="fa fa-fw fa-user fa-3x" style="color:black" onclick="document.getElementById('admin_login').submit()">
                    </a>
                    <p>Admin</p>
                    <a href="#" class="fa fa-fw fa-user fa-3x" style="color:green" onclick="document.getElementById('pm_login').submit()">
                    </a>
                    <p>Project&nbspManager</p>
                </div>

                <div class="col two">
                    <a href=" #" class="fa fa-fw fa-user fa-3x" style="color:red" onclick="document.getElementById('dev_login').submit()">
                    </a>
                    <p>Developer</p>
                    <a href="#" class="fa fa-fw fa-user fa-3x" style="color:blue" onclick="document.getElementById('submitter_login').submit()">
                    </a>
                    <p>Submitter</p>
                </div>
            </div>
        </div>
        <div class="row mt-0">
            <div class="col mt-0">
                <p class="mt-0">Have an account? <a href="login.php">Sign in</a>
                <p class="mt-0">Sign up? <a href="signup.php">Sign up</a>
            </div>
        </div>
    </div>
</div>


<form class="hidden" id="admin_login" action="login.php" method="POST">
    <input type="hidden" name="email" value="demoadmin@gmail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<form class="hidden" id="dev_login" action="login.php" method="POST">
    <input type="hidden" name="email" value="demodev@gmail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>


<form class="hidden" id="pm_login" action="login.php" method="POST">
    <input type="hidden" name="email" value="demopm@gmail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<form class="hidden" id="submitter_login" action="login.php" method="POST">
    <input type="hidden" name="email" value="nbohr@gmail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<?php include('shared/closing_tags.php') ?>