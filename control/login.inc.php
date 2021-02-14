<?php
require('shared/post_check.inc.php');
require_once('controller.class.php');
require_once('form_handlers/LoginHandler.class.php');

if (isset($_POST['login_submit'])) {
    $login_handler = new LoginHandler($_POST);
    $errors = $login_handler->do_login();
}

if (!$errors) {
    header('location: ../view/dashboard.php');
    exit();
} else {
    session_start();
    $_SESSION['errors'] = $errors;
    $_SESSION['post_data'] = $_POST;
    header('location: ../view/login.php');
    exit();
}
