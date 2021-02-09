<?php
include('post_check.inc.php');
if (!$_POST) {
    header('location: dashboard.php');
    exit();
}
