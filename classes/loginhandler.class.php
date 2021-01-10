<?php

class LoginHandler
{

  private $data;
  private $errors = [];
  private static $fields = ['username', 'pwd'];

  public function __construct($post_data)
  {
    $this->data = $post_data;
  }

  public function validate_form()
  {

    foreach (self::$fields as $field) {
      if (!array_key_exists($field, $this->data)) {
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validate_username();
    $this->validate_pwd();
    return $this->errors;
  }

  public function authenticate_user()
  {
    session_start();
    $_SESSION['username'] = 'Kristian';
    return true;
  }


  private function validate_username()
  {

    $val = trim($this->data['username']);

    if (empty($val)) {
      $this->addError('username', 'Please fill in username');
    } else {
      if (!preg_match('/^[a-zA-Z0-9]{6,12}$/', $val)) {
        $this->addError('username', 'username must be 6-12 chars & alphanumeric');
      }
    }
  }

  private function validate_pwd()
  {

    $val = trim($this->data['pwd']);

    if (empty($val)) {
      $this->addError('pwd', 'Please fill in password');
    }
  }

  private function addError($key, $val)
  {
    $this->errors[$key] = $val;
  }
}
