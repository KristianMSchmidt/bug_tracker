<?php
include_once('../includes/set_session_vars.inc.php');
include_once('../includes/auto_loader.inc.php');

class SignupHandler
{
    private $data;
    private $input_errors = [];
    private $signup_error = '';
    private $signup_succes = False;
    private static $fields = ['firstname', 'lastname', 'email', 'pwd', 'pwd_repeat'];

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

        $this->validate_firstname();
        $this->validate_lastname();
        $this->validate_email();
        $this->validate_pwd();
        if (!isset($this->input_errors['pwd'])) {
            $this->validate_pwd_repeat();
        }

        if (!$this->input_errors) {
            $this->signup_attempt();
        }

        return array(
            'input_errors' => $this->input_errors,
            'signup_error' => $this->signup_error,
            'signup_succes' => $this->signup_succes
        );
    }

    private function validate_firstname()
    {

        $val = trim($this->data['firstname']);

        if (empty($val)) {
            $this->add_input_error('firstname', 'please fill in first name');
        } else {
            if (!preg_match('/^[a-zA-Z]{2,20}$/', $val)) {
                $this->add_input_error('firstname', 'first name must be 2-20 chars & alphabetic');
            }
        }
    }

    private function validate_lastname()
    {

        $val = trim($this->data['lastname']);

        if (empty($val)) {
            $this->add_input_error('lastname', 'please fill in last name');
        } else {
            if (!preg_match('/^[a-zA-Z]{2,20}$/', $val)) {
                $this->add_input_error('lastname', 'last name name must be 2-20 chars & alphabetic');
            }
        }
    }

    private function validate_email()
    {
        $val = trim($this->data['email']);

        if (empty($val)) {
            $this->add_input_error('email', 'email cannot be empty');
        } else {
            if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                $this->add_input_error('email', 'email must be a valid email address');
            }
        }
    }

    private function validate_pwd()
    {
        $val = trim($this->data['pwd']);

        if (empty($val)) {
            $this->add_input_error('pwd', 'Please fill in password');
        } else {
            if (!preg_match('/^\w{5,}$/', $val)) {
                $this->add_input_error('pwd', 'password must be alphanumeric & longer than or equals 5 chars');
            }
        }
    }

    private function validate_pwd_repeat()
    {
        $val = trim($this->data['pwd_repeat']);
        $pwd = trim($this->data['pwd']);

        if (empty($val)) {
            $this->add_input_error('pwd_repeat', 'Please fill in repeated password');
        } else {
            if ($val !== $pwd) {
                $this->add_input_error('pwd_repeat', 'the two entered passwords did not match');
            }
        }
    }

    private function add_input_error($key, $val)
    {
        $this->input_errors[$key] = $val;
    }

    private function signup_attempt()
    {   // To do: Move this functionality to controller?
        $contr = new Controller();
        $email_taken = $contr->get_user_by_email($this->data['email']);
        if ($email_taken) {
            $this->signup_error = 'There is already a user with this email';
            return;
        }
        $this->data['role_id'] = 3; // New users start out as developers.
        $contr->set_user(
            $this->data['firstname'],
            $this->data['lastname'],
            $this->data['pwd'],
            $this->data['email'],
            $this->data['role_id']
        );
        $new_user = $contr->get_user_by_email($this->data['email']);
        set_session_vars($new_user);
        $this->signup_succes = True;
    }
}
