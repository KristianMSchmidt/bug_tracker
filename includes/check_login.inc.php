<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: views/login.php?forbidden");
    exit();
}
