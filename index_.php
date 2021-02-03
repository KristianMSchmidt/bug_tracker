<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('location: views/dashboard.php');
    exit();
} else {
    header('location: views/demo_login.php');
}
