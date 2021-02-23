<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    require_once('../../control/controller.class.php');
    require('../../control/shared/human_timing.inc.php');
    $contr = new Controller;
    if (isset($_GET['seen'])) {
        $contr->make_notifications_seen($_SESSION['user_id']);
    }
    $data = $contr->get_notifications_by_user_id($_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug_Tracker</title>

    <!-- font awesome icon library -->
    <link href="../css/font-awesome/css/all.css" rel="stylesheet">

    <!-- w3-css style sheet -->
    <link rel="stylesheet" href="../css/w3.css">

    <!-- My custom css -->
    <link rel="stylesheet" href="../css/main.css">

    <!-- JS chart library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
</head>

<body>
    <div class="my_navbar">
        <div class="branding_area">
            <ul class="nav_list">
                <li><i class="fas fa-bug" aria-hidden="true"></i> Welcome to </li>
                <li class="logo">Bug_Tracker</li>
            </ul>
        </div>
        <div class="main_nav">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="left_main_nav">
                    <p><?php echo $_SESSION['full_name'] ?> | <?php echo $_SESSION['role_name'] ?></p>
                </div>

                <div class="dropdown">
                    <!-- notifications dropdown btn -->
                    <?php if ($data['num_unseen'] > 0) : ?>

                        <button class='dropbtn notifications' onclick="seen_redirect()">
                            <span id='bell' class='notifications dropbtn fa-stack'>
                                <i class='notifications dropbtn fas fa-bell fa-stack' data-count=<?php echo $data['num_unseen'] ?>></i>
                            </span>
                        </button>
                    <?php else : ?>
                        <button class='dropbtn notifications'>
                            <span id='bell' class='notifications dropbtn fa-stack'>
                                <i class='notifications dropbtn fas fa-bell fa-stack'></i>
                            </span>
                        </button>
                    <?php endif ?>

                    <!-- notifications dropdown content -->
                    <div id="notifications" class="dropdown-content notifications">
                        <?php if (count($data['notifications']) == 0) : ?>
                            <a href="#">You don't have any notifications yet</a>
                        <?php else : ?>
                            <?php foreach ($data['notifications'] as $notification) :
                                if ($notification['type'] == 1) {
                                    /* role update */
                                    $href = "profile_settings.php";
                                    $news_item = $contr->get_role_name_by_role_id($notification['info_id']);
                                } elseif ($notification['type'] == 2) {
                                    /* assigned to ticket */
                                    $href = "ticket_details.php?ticket_id={$notification['info_id']}";
                                    $news_item = $contr->get_ticket_by_id($notification['info_id'])['title'];
                                } elseif ($notification['type'] == 3) {
                                    /* un-assigned from ticket */
                                    $href = "my_tickets.php";
                                    $news_item = $contr->get_ticket_by_id($notification['info_id'])['title'];
                                } elseif ($notification['type'] == 4) {
                                    /* enrolled in project */
                                    $href = "project_details.php?project_id={$notification['info_id']}";
                                    $news_item = $contr->get_project_name_by_id($notification['info_id']);
                                } elseif ($notification['type'] == 5) {
                                    /* dis-enrolled from project */
                                    $href = "my_projects.php?order=updated_at&dir=desc";
                                    $news_item = $contr->get_project_name_by_id($notification['info_id']);
                                } elseif ($notification['type'] == 6) {
                                    /* new comment to your ticket */
                                    $href = "ticket_details.php?ticket_id={$notification['info_id']}";
                                    $news_item = $contr->get_ticket_by_id($notification['info_id'])['title'];
                                }
                                $elapsed_time = human_timing(strtotime($notification["created_at"]));
                                $notification_str = "<b>{$notification["creator_name"]}</b> {$notification['submitter_action']} '{$news_item}'</i><br>{$elapsed_time} ago";
                                echo "<a href='{$href}'>{$notification_str}</a>"; ?>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>

                    <!-- user actions dropdown btn -->
                    <button class='user_actions dropbtn'>
                        <i class="user_actions dropbtn fas fa-user"></i>
                        <i class="user_actions dropbtn fas fa-caret-down hide_xsmall"></i>
                        <span class='user_actions dropbtn fa-stack hide_xsmall' style="padding:0; width:0;">
                        </span>
                    </button>

                    <!-- user actions dropdown content -->
                    <form action="../../control/logout.inc.php" method="post" id="logout_form"></form>
                    <div id="user_actions" class="dropdown-content user_actions">
                        <a href="profile_settings.php">Profile settings</a>
                        <a href="#" onclick="document.getElementById('logout_form').submit()">Log out</a>
                    </div>
                </div>
            <?php endif ?>
        </div> <!-- main_nav -->
    </div> <!-- my_navbar -->
    <div class=" sidebar_and_main_container">
        <div class="sidebar">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <!-- Show sidebar links depending on role -->
                <a href="dashboard.php" id="dashboard_link"><i class="fas fa-home"></i> &nbsp;Dashboard</a>
                <?php if ($_SESSION['role_name'] == 'Admin' || $_SESSION['role_name'] == 'Project Manager') : ?>
                    <a href="manage_project_users.php?project_id=none" id="manage_project_users_link"><i class="fas fa-user-plus"></i> &nbsp;Manage Project Users</a>
                    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                        <a href="manage_user_roles.php" id="manage_user_roles_link"><i class="fas fa-users"></i> &nbsp;Manage User Roles</a>
                    <?php endif ?>
                    <a href="users_overview.php?order=full_name&dir=asc" id="users_overview_link"><i class="fas fa-user-friends"></i> &nbsp;Users Overview</a>
                <?php endif ?>
                <a href="my_projects.php?order=updated_at&dir=desc" id="my_projects_link"><i class="fas fa-industry"></i> &nbsp;My Projects</a>
                <a href="my_tickets.php" id="my_tickets_link"><i class="fas fa-ticket-alt"></i> &nbsp;My Tickets</a>
            <?php endif ?>
        </div>