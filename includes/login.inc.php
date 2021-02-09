<?php
include('../classes/form_handlers/LoginHandler.class.php');

if (isset($_POST['login_submit'])) {
    $login_handler = new LoginHandler($_POST);
    $login_handler->process_input();
}
