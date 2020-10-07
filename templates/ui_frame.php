<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug_Tracker</title>
    <link rel="stylesheet" href="templates/bug_style.css">
    <!-- Load an icon library -->
    <!-- https://fontawesome.com/v4.7.0/icons/ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="templates/dropdown.js"></script>
</head>

<body>

    <?php
    session_start(); //this will start/resume session on all scripts with this header
    ?>

    <!-- if user is NOT logged in -->
    <?php if (!isset($_SESSION['username'])) : ?>

        <div class="wrapper">

            <div class="upper-left-corner">
                <div style="text-align:center">
                    <i class="fa fa-fw fa-bug fa-lg"></i>
                    <p>WELCOME</p>
                    <br>
                    <p id="username">to Bug_Tracker</p>
                </div>
            </div>

            <div class="header">
            </div>

            <div class="sidebar">
            </div>

            <!-- if user ISlogged in -->
        <?php else : ?>

            <?php require 'includes/tools.inc.php'; ?>

            <div class="wrapper">

                <div class="upper-left-corner">
                    <div style="text-align:center">
                        <i class="fa fa-fw fa-bug fa-lg"></i>
                        <p>WELCOME</p>
                        <br>
                        <p id="username"><?php echo $_SESSION['username']; ?></p>
                    </div>
                </div>

                <div class="sidebar">
                    <a class="active" href="dashboard.php"><i class="fa fa-fw fa-home"></i>Dashboard</a>
                    <a href="manage_role_assignment.php"><i class="fa fa-fw fa-users"></i>Manage Role Assignment</a>

                    <a href="show_users.php"><i class="fa fa-fw fa-users"></i>Manage Role Assignment</a>
                    <a href="show_projects.php"><i class="fa fa-fw fa-user-plus"></i>Manage Project Users </a>
                    <a href="#contact"><i class="fa fa-fw fa-industry"></i>My Projects</a>
                    <a href="#contact"><i class="fa fa-fw fa-ticket"></i>My Tickets</a>
                </div>

                <div class="header">
                    <p>Logged in as <b><?php echo $role_str[$_SESSION['role']]; ?></b></p>

                    <div class="dropdown">
                        <button onclick="myFunction1()" class="dropbtn one">
                            <i class="fa fa-fw fa-user"></i>
                            USER ACTIONS</button>

                        <div id="myDropdown1" class="dropdown-content one">
                            <a href="#about">Profile</a>
                            <a href="#about">Settings</a>
                            <a href="includes/logout.inc.php">Log out</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button onclick="myFunction2()" class="dropbtn two">
                            <i class="fa fa-fw fa-bell"></i>
                            NOTIFICATIONS</button>

                        <div id="myDropdown2" class="dropdown-content two">
                            <a href="#">N1</a>
                            <a href="#">N2</a>
                        </div>
                    </div>

                </div>

            <?php endif ?>