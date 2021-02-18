<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    // only load js-scripts if user is logged in
    echo "<script src='../js/main.js'></script>";
}

// Clean session variable after each page rendering
foreach ($_SESSION as $key => $value) {
    if (!in_array($key, ['user_id', 'full_name', 'user_email', 'role_name'])) {
        unset($_SESSION[$key]);
    }
}

?>
<script src="../js/screen_size_detector.js"></script>
</body>

</html>