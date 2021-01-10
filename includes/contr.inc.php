<?php

include('includes/auto_loader.inc.php');

// If user is not logged in, show login page
session_start(); //session_destroy();
if (!isset($_SESSION['username'])) {
    include('views/page_content/login.view.php');
}

// Handle get requests
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!$_GET) {
        include('views/page_content/dashboard.view.php');
    }
    switch ($_GET['requested_action']) {
        case 'login_attempt':
            echo 'rgkerok';
    }
}

// Handle post requests
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['requested_action']) {

        case 'login_attempt':
            // Try to login user
            // object = LoginManager($_POST);
            // if no errors -> include(/'views/page_content_dashboard.php');
            // if errors -> include(views/page_content/login.php')
            break;

        case 'my_projects':
            include('views/page_content/my_projects.view.php');
            break;

        case 'my_tickets':
            include('views/page_content/my_tickets.view.php');
            break;

        default:
            # code...
            break;
    }
}
