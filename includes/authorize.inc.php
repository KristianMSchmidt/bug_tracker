<?php
function authorize($roles)
{

    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['role_name'])) {
        header('location: demo_login.php');
        exit();
    }
    if (!in_array($_SESSION['role_name'], $roles)) {
        header('location:dashboard.php');
    }
}
