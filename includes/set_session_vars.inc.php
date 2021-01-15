
<?php
function set_session_vars($user)
{
    session_start();
    //echo session_id();
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['lastname'] = $user['lastname'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role_name'] = $user['role_name'];
}
