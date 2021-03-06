<?php
require_once('LogIn.class.php');
require_once('controller.class.php');

class LoginHandler extends LogIn
{
  private $data;
  private $errors = [];

  public function __construct($post_data)
  {
    $this->data = $post_data;
  }

  public function do_login()
  {

    $this->validate_email();
    $this->validate_pwd();

    if (!$this->errors) {
      $this->login_attempt();
    }
    return $this->errors;
  }

  private function validate_email()
  {

    $val = trim($this->data['email']);

    if (empty($val)) {
      $this->add_error('email', 'Please fill in email');
    }
  }

  private function validate_pwd()
  {

    $val = trim($this->data['pwd']);

    if (empty($val)) {
      $this->add_error('pwd', 'Please fill in password');
    }
  }

  private function login_attempt()
  {
    $contr = new Controller();
    $pwd = trim($this->data['pwd']);
    $user = $contr->get_user_by_email($this->data['email']);
    if ($user) {
      $pwd_db = $user['password'];
      $psw_check = password_verify($pwd, $pwd_db);
      if ($psw_check) {
        $this->set_session_vars($user, $contr);
      } else {
        $this->add_error('login_error', 'Wrong email or password');
      }
    } else {
      $this->add_error('login_error', 'Wrong email or password');
    }
  }

  private function add_error($key, $val)
  {
    $this->errors[$key] = $val;
  }
}
