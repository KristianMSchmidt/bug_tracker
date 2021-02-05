<?php if (!($_SESSION['role_name'] == 'Admin' || $_SESSION['role_name'] == 'Project Manager')) {
    header('location: dashboard.php');
}
