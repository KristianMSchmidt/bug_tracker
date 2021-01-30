<?php
include_once('../includes/set_session_vars.inc.php');
include_once('../includes/auto_loader.inc.php');


class LoginHandler
{
  private $data;
  private $input_errors = [];
  private $login_error = "";
  private $login_succes = False;
  private static $fields = ['email', 'pwd'];

  public function __construct($post_data)
  {
    $this->data = $post_data;
  }

  public function process_input()
  {
    foreach (self::$fields as $field) {
      if (!array_key_exists($field, $this->data)) {
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validate_email();
    $this->validate_pwd();

    if (!$this->input_errors) {
      $this->login_attempt();
    }

    return array(
      'input_errors' => $this->input_errors,
      'login_error' => $this->login_error,
      'login_succes' => $this->login_succes
    );
  }

  private function validate_email()
  {

    $val = trim($this->data['email']);

    if (empty($val)) {
      $this->add_input_error('email', 'Please fill in email');
    }
  }

  private function validate_pwd()
  {

    $val = trim($this->data['pwd']);

    if (empty($val)) {
      $this->add_input_error('pwd', 'Please fill in password');
    }
  }

  private function add_input_error($key, $val)
  {
    $this->input_errors[$key] = $val;
  }

  private function login_attempt()
  // To do: Move this functionality to controller?
  {
    $this->login_error = 'Wrong email or password';
    $contr = new Controller();
    $pwd = $this->data['pwd'];
    $user = $contr->get_user_by_email($this->data['email']);
    if ($user) {
      $pwd_db = $user['password'];
      $psw_check = password_verify($pwd, $pwd_db);
      if ($psw_check) {
        $this->login_succes = True;
        $this->login_error = '';
        set_session_vars($user, $contr);
      }
    }
  }
}
