
<?php

class LogIn
{
    protected function set_session_vars($user, $contr)
    {
        session_regenerate_id(TRUE);
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role_name'] = $user['role_name'];
        $contr->set_session($user['user_id'], session_id());
    }
}
