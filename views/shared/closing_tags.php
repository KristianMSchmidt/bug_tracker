<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    // only load js-scripts if user is logged in
    echo "<script src='../static/scripts/main.js'></script>";
}
?>

</body>

</html>