<?php
include('../includes/shared/post_check.inc.php');
include('../classes/form_handlers/LoginHandler.class.php');

if (isset($_POST['login_submit'])) {
    $login_handler = new LoginHandler($_POST);
    $errors = $login_handler->do_login();
}

if (!$errors) {
    header('location: ../views/dashboard.php');
    exit();
} else {
    session_start();
    $_SESSION['errors'] = $errors;
    $_SESSION['post_data'] = $_POST;
    header('location: ../views/login.php');
    exit();
}
