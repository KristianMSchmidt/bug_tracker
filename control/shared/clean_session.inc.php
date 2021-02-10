<?php
foreach ($_SESSION as $key => $value) {
    if (!in_array($key, ['user_id', 'full_name', 'user_email', 'role_name'])) {
        unset($_SESSION[$key]);
    }
}
