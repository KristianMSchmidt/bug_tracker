<?php
include('../classes/form_handlers/LoginHandler.class.php');
if (isset($_POST['signup_submit'])) {

    include_once('../includes/shared/auto_loader.inc.php');
    include('../classes/form_handlers/SignupHandler.class.php');
    $signup_handler = new SignUpHandler($_POST);
    $signup_handler->process_input();
}
print_r("HEJ");
exit();
