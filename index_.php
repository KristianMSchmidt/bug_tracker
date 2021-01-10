<?php
session_start();
if (isset($_SESSION['username'])) {
    header('location: views/dashboard.php');
    exit();
} else {
    header('location: views/login.php');
}
