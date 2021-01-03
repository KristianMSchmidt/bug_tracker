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

    <?php if (!isset($_SESSION['username'])) : ?>
        <!-- user is not logged in -->
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

        <?php else : ?>
            <!-- user is logged in -->
            <?php
            include('includes/db_connect.inc.php');
            include('includes/human_timing.inc.php');

            $sql =
                "SELECT unseen, notification, notification_type, notifications.created_at, notifications.user_id, username as created_by
            FROM notifications
            JOIN notification_types
            ON notifications.notification_type = notification_types.notification_type_id
            JOIN users
            ON notifications.created_by = users.user_id
            WHERE notifications.user_id = {$_SESSION['user_id']}
            ORDER BY notification_id DESC
            LIMIT 100";

            // make query and get result
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                //error message: A database error occured
                echo 'query error: ' . mysqli_error($conn);
                exit();
            }

            // fetch the resulting rows as an associative array
            $notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // free result from memory and close connection
            mysqli_close($conn);

            $unseen = 0;
            foreach ($notifications as $n) {
                $unseen += $n['unseen'];
            }
            ?>

            <form class="hidden" id="seen_notifications_form" action="includes/seen_notifications.inc.php" method="POST">
                <input type="hidden" name="user_id" value=<?php echo $_SESSION['user_id'] ?>>
                <input type="hidden" name="page_name" value="" id="form_input_page_name">
            </form>

            <script>
                page_name = window.location.href.split("?")[0].split("/")[5] //e.g. 'login.php'
                document.getElementById("form_input_page_name").value = page_name;
            </script>

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
                    <a href="manage_role_assignment.php"><i class="fa fa-fw fa-users"></i>Manage User Roles</a>
                    <a href="show_projects.php"><i class="fa fa-fw fa-user-plus"></i>Manage Project Users </a>
                    <a href="my_projects.php"><i class="fa fa-fw fa-industry"></i>My Projects</a>
                    <a href="my_tickets.php"><i class="fa fa-fw fa-ticket"></i>My Tickets</a>
                </div>

                <div class="header">
                    <p>Logged in as <b><?php echo $_SESSION['role_name']; ?></b></p>

                    <style>
                        .fa {
                            color: #303030;
                        }

                        .fa:hover,
                        .fa:focus {
                            color: black;
                        }
                    </style>
                    <div class="dropdown">
                        <button onclick="myFunction1()" class="dropbtn one">
                            <span class="fa-stack fa-1x">
                                <i class=" fa fa-user fa-stack-1x fa-inverse"></i>
                            </span>
                            USER ACTIONS</button>

                        <div id="myDropdown1" class="dropdown-content one">
                            <a href="profile_settings.php">Profile settings</a>
                            <a href="includes/logout.inc.php">Log out</a>
                        </div>
                    </div>

                    <form class="hidden" id="notifications_form" action="includes/remove_notifications.inc.php" method="POST">
                        <input type="hidden" name="user_id" value="Demo Admin">
                    </form>

                    <script>
                        function remove_notifications() {
                            document.getElementById("seen_notifications_form").submit();
                        }
                    </script>

                    <div class="dropdown">

                        <?php
                        if ($unseen > 0) {
                            echo "<button onclick='remove_notifications()' class='dropbtn two'>
                                    <span id = 'bell' class='fa-stack fa-1x has-badge' data-count={$unseen}>
                                        <i class='fa fa-bell fa-stack-1x fa-inverse'></i>
                                    </span>
                                NOTIFICATIONS
                                </button>";
                        } else {
                            echo "<button onclick='myFunction2()' class='dropbtn two'>
                                    <span class='fa-stack fa-1x'>
                                      <i class='fa fa-bell fa-stack-1x fa-inverse'></i>
                                     </span>
                                    NOTIFICATIONS
                                  </button>";
                        }
                        ?>

                        <div id="myDropdown2" class="dropdown-content two">
                            <?php foreach ($notifications as $notification) : ?>
                                <?php
                                if ($notification['notification_type'] == 1) {
                                    echo '<a href="profile_settings.php">';
                                } elseif ($notification['notification_type'] == 2) {
                                    echo '<a href="my_tickets.php">';
                                } elseif ($notification['notification_type'] == 3) {
                                    echo '<a href="my_projects.php">';
                                }
                                ?>
                                <?php echo '<b>' . $notification["created_by"] . '</b>'; ?>
                                <?php echo $notification["notification"]; ?>
                                <?php $elapsed_time = humanTiming(strtotime($notification["created_at"])); ?>
                                <?php echo '<br>' . $elapsed_time . ' ago'; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

                <script>
                    url = window.location.href

                    if (url.split("?")[1] == "seen=succes") {
                        myFunction2()
                    }
                </script>

            <?php endif ?>