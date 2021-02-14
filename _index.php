<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('location: view/dashboard.php');
    exit();
} else {
    header('location: view/demo_login.php');
}
