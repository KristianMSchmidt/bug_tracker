<?php
require_once('form_handlers/SignupHandler.class.php');
session_start();

$signup_handler = new SignUpHandler($_POST);
$errors = $signup_handler->sign_up();

if (!$errors) {
    header('location: ../view/pages/dashboard.php');
    exit();
} else {
    $_SESSION['errors'] = $errors;
    $_SESSION['post_data'] = $_POST;
    header('location: ../view/pages/signup.php');
    exit();
}
