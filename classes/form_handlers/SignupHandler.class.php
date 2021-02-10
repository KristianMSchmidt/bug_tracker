<?php
include_once('../includes/shared/set_session_vars.inc.php');
include_once('../includes/shared/auto_loader.inc.php');

class SignupHandler
{
    private $data;
    private $errors;

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }
    public function sign_up()
    {
        session_start();
        $this->validate_full_name();
        $this->validate_email();

        if (!$this->errors) {
            $this->validate_pwd();
        }

        if (!$this->errors) {
            $this->validate_pwd_repeat();
        }

        if (!$this->errors) {
            $this->signup_attempt();
        }
        return $this->errors;
    }

    private function validate_full_name()
    {

        $val = trim($this->data['full_name']);

        if (empty($val)) {
            $this->add_error('full_name', 'please fill in full name');
        } else {
            if (!preg_match("/^[a-zA-ZæøåÆØÅ' ]{5,40}$/", $val)) {
                $this->add_error('full_name', 'full name must be 5-40 chars & alphabetic');
            }
        }
    }

    private function validate_email()
    {
        $val = trim($this->data['email']);

        if (empty($val)) {
            $this->add_error('email', 'email cannot be empty');
        } else {
            if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                $this->add_error('email', 'email must be a valid email address');
            }
        }
    }

    private function validate_pwd()
    {
        $val = trim($this->data['pwd']);

        if (empty($val)) {
            $this->add_error('pwd', 'Please fill in password');
        } else {
            if (!preg_match('/^\w{5,}$/', $val)) {
                $this->add_error('pwd', 'password must be alphanumeric & longer than or equals to 5 chars');
            }
        }
    }

    private function validate_pwd_repeat()
    {
        $val = trim($this->data['pwd_repeat']);
        $pwd = trim($this->data['pwd']);

        if (empty($val)) {
            $this->add_error('pwd_repeat', 'Please fill in repeated password');
        } else {
            if ($val !== $pwd) {
                $this->add_error('pwd_repeat', 'the two entered passwords did not match');
            }
        }
    }

    private function signup_attempt()
    {
        $contr = new Controller();
        $email_taken = $contr->get_user_by_email($this->data['email']);
        if ($email_taken) {
            $this->add_error('signup_error', 'There is already a user with this email');
        } else {
            $this->data['role_id'] = 3; // New users start out as developers.
            $contr->set_user(trim($this->data['full_name']), trim($this->data['pwd']), trim($this->data['email']), $this->data['role_id']);
            $new_user = $contr->get_user_by_email($this->data['email']);
            set_session_vars($new_user, $contr);
        }
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
