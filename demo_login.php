<?php
require 'templates/ui_frame.php';
?>

<div class="main">
    <h2> Demo_User Login </h2>

    <style>
        .demo-login_wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            grid-template-rows: 1fr 1fr;
            /* border: 1px solid black;*/
            padding-top: 1em;
            padding-bottom: 0;
            margin: 0;
        }

        .hidden {
            display: none;
        }
    </style>

    <div class="demo-login_wrapper">

        <form class="hidden" id="dev_login" action="includes/login.inc.php" method="POST">
            <input type="hidden" name="user_login" value="Demo_Developer">
            <input type="hidden" name="password" value="stjerne">
            <input type="hidden" name="login_submit" value="">
        </form>


        <form class="hidden" id="pm_login" action="includes/login.inc.php" method="POST">
            <input type="hidden" name="user_login" value="Demo_Project_Manager">
            <input type="hidden" name="password" value="stjerne">
            <input type="hidden" name="login_submit" value="">
        </form>

        <form class="hidden" id="admin_login" action="includes/login.inc.php" method="POST">
            <input type="hidden" name="user_login" value="Demo_Admin">
            <input type="hidden" name="password" value="stjerne">
            <input type="hidden" name="login_submit" value="">
        </form>

        <form class="hidden" id="submitter_login" action="includes/login.inc.php" method="POST">
            <input type="hidden" name="user_login" value="Demo_Submitter">
            <input type="hidden" name="password" value="stjerne">
            <input type="hidden" name="login_submit" value="">
        </form>


        <div></div>

        <div>
            <a href=" #" class="fa fa-fw fa-user fa-3x" style="color:red" onclick="document.getElementById('dev_login').submit()">
            </a>
            <p>Developer</p>
        </div>

        <div>
            <a href="#" class="fa fa-fw fa-user fa-3x" style="color:green" onclick="document.getElementById('pm_login').submit()">
            </a>
            <p>Project Manager</p>
        </div>

        <div></div>
        <div></div>

        <div>
            <a href="#" class="fa fa-fw fa-user fa-3x" style="color:black" onclick="document.getElementById('admin_login').submit()">
            </a>
            <p>Admin</p>
        </div>

        <div>
            <a href="#" class="fa fa-fw fa-user fa-3x" style="color:blue" onclick="document.getElementById('submitter_login').submit()">
            </a>
            <p>Submitter</p>
        </div>
        <div></div>
    </div>

    <p>Have an account? <a href="login.php">Sign in</a>

        <?php
        require 'templates/footer.php';

        ?>