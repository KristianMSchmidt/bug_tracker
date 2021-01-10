<?php

include('includes/auto_loader.inc.php');

/* IF USER IS NOT LOGGED IN */

if (!isset($_SESSION['username'])) {
    $errors = [];

    if (isset($_POST['login_submit'])) {
        echo "Login submit";
        // validate form entries
        $loginhandler = new LoginHandler($_POST);
        $form_errors = $loginhandler->validate_form();
        // if  for errors is empty 
        //    validate database -
        //    if still no errors
        //login in user -> go to dashboard
        if (!$form_errors) {
            echo "no form errors";
            if ($login_handler->authenticate_user()) {
                header('views/page_content/dashboard.view.php');
            } else {
                include('views/page_content/login.view.php');
            }
        } else {
            echo "form errors";
            print_r($form_errors);

            include('views/page_content/login.view.php');
        }
        //    else show form with error message 
        //else
        //    show form with errors.   
    }
    include('views/page_content/login.view.php');
}


/* IF USER IS LOGGED IN */

// Handle get requests
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!$_GET) {
        include('views/page_content/dashboard.view.php');
    }
    switch ($_GET['show']) {
        case 'dashboard':
            include('views/page_content/dashboard.php');
            break;
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
