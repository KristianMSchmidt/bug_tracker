<?php
include_once('shared/post_check.inc.php');
include_once('form_handlers/SignupHandler.class.php');

$signup_handler = new SignUpHandler($_POST);
$errors = $signup_handler->sign_up();

if (!$errors) {
    header('location: ../views/dashboard.php');
    exit();
} else {
    $_SESSION['errors'] = $errors;
    $_SESSION['post_data'] = $_POST;
    header('location: ../views/signup.php');
    exit();
}
