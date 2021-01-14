<?php
include_once('../includes/set_session_vars.inc.php');
include_once('../includes/auto_loader.inc.php');

class LoginHandler
{
  private $data;
  private $input_errors = [];
  private $login_error = "";
  private $login_succes = False;
  private static $fields = ['username', 'pwd'];

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

    $this->validate_username();
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

  private function validate_username()
  {

    $val = trim($this->data['username']);

    if (empty($val)) {
      $this->add_input_error('username', 'Please fill in username');
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
    $this->login_error = 'Wrong username or password';
    $contr = new Controller();
    $pwd = $this->data['pwd'];
    $user = $contr->get_user_by_username($this->data['username']);
    if ($user) {
      $pwd_db = $user['password'];
      $psw_check = password_verify($pwd, $pwd_db);
      if ($psw_check) {
        $this->login_succes = True;
        $this->login_error = '';
        set_session_vars($user);
      }
    }
  }
}
