<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug_Tracker(2)</title>
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
    <?php
    include('includes/db_connect.inc.php');
    $sql =
        "SELECT seen, notification, notifications.created_at, username as created_by
        FROM notifications 
        JOIN notification_types
        ON notifications.notification_type = notification_types.notification_type_id
        JOIN users
        ON notifications.created_by = users.user_id
        WHERE notifications.user_id=1
        ORDER BY notification_id DESC
        LIMIT 5";

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


    function humanTiming($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }
    $time = strtotime('2020-12-31 12:25:43');
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
                    <a href="manage_role_assignment.php"><i class="fa fa-fw fa-users"></i>Manage User Roles</a>
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
                            <a href="includes/logout.inc.php">Log out</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button onclick="myFunction2()" class="dropbtn two">
                            <i class="fa fa-fw fa-bell"></i>
                            NOTIFICATIONS</button>
                        <div id="myDropdown2" class="dropdown-content two">
                            <?php foreach ($notifications as $notification) : ?>
                                <a href="show_projects.php">
                                    <?php echo '<b>' . $notification["created_by"] . '</b>'; ?>
                                    <?php echo $notification["notification"]; ?>
                                    <?php $elapsed_time = humanTiming(strtotime($notification["created_at"])); ?>
                                    <?php echo '<br>' . $elapsed_time . ' ago'; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

            <?php endif ?>