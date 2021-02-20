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
    <div class="demo_login">
        <div class="card">
            <div class="w3-container card-head w3-center">
                <h3>Demo Login</h3>
            </div>
            <div class="row">
                <div class="col one">
                    <!-- Admin -->
                    <a href="#" class="fa fa-fw fa-user fa-3x w3-tooltip" style="color:black" onclick="document.getElementById('admin_login').submit()">
                        <span class="w3-text w3-tag demo admin">
                            Admins have access to all data and functionality of the site</span>
                    </a>
                    <p>Admin</p>

                    <!-- Project Manager -->
                    <a href="#" class="fa fa-fw fa-user fa-3x w3-tooltip" style="color:green" onclick="document.getElementById('pm_login').submit()">
                        <span class="w3-text w3-tag demo pm">
                            Project Manager can assign users to projects</span>
                    </a>
                    <p>Project&nbspManager</p>
                </div>

                <div class="col two">
                    <!-- Developer -->
                    <a href=" #" class="fa fa-fw fa-user fa-3x w3-tooltip" style="color:red" onclick="document.getElementById('dev_login').submit()">
                        <span class="w3-text w3-tag demo dev">
                            Developers can see and comment on their tickets</span>
                    </a>
                    <p>Developer</p>

                    <!-- Submitter -->
                    <a href="#" class="fa fa-fw fa-user fa-3x w3-tooltip" style="color:blue" onclick="document.getElementById('submitter_login').submit()">
                        <span class="w3-text w3-tag demo sub">
                            Submitter can create new tickets</span>
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

<form class="hidden" id="admin_login" action="../../control/login.inc.php" method="POST">
    <input type="hidden" name="email" value="demoadmin@mail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<form class="hidden" id="pm_login" action="../../control/login.inc.php" method="POST">
    <input type="hidden" name="email" value="demopm@mail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<form class="hidden" id="dev_login" action="../../control/login.inc.php" method="POST">
    <input type="hidden" name="email" value="demodev@mail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<form class="hidden" id="submitter_login" action="../../control/login.inc.php" method="POST">
    <input type="hidden" name="email" value="demosub@mail.com">
    <input type="hidden" name="pwd" value="stjerne">
    <input type="hidden" name="login_submit" value="">
</form>

<?php require('page_frame/closing_tags.php')
?>