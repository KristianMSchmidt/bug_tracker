<?php
include_once('shared/set_session_vars.inc.php');
include_once('shared/auto_loader.inc.php');


class LoginHandler
{
  private $data;
  private $errors = [];

  public function __construct($post_data)
  {
    $this->data = $post_data;
  }

  public function process_input()
  {
    session_start();

    $this->validate_email();
    $this->validate_pwd();

    if (!$this->errors) {
      $this->login_attempt();
    }

    if (!$this->errors) {
      // login succesfull
      header('location: ../views/dashboard.php');
      exit();
    } else {
      //return with error messages and data
      $_SESSION['errors'] = $this->errors;
      $_SESSION['post_data'] = $this->data;
      header('location: ../views/login.php');
      exit();
    }
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
    $pwd = $this->data['pwd'];
    $user = $contr->get_user_by_email($this->data['email']);
    if ($user) {
      $pwd_db = $user['password'];
      $psw_check = password_verify($pwd, $pwd_db);
      if ($psw_check) {
        //log in user
        set_session_vars($user, $contr);
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
