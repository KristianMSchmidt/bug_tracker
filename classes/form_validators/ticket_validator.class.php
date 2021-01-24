<?php
// THIS CLASS I CURRENTLY NOT USED
class TicketValidator
{

    private $data;
    private $errors = [];
    private static $fields = ['title', 'description'];

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

        $this->validate_title();
        $this->validate_description();
        return $this->errors;
    }

    private function validate_title()
    {

        $val = trim($this->data['title']);

        if (empty($val)) {
            $this->addError('title', 'Title cannot be empty');
        } else {
            if (!(strlen($val) < 25 && strlen($val) > 5)) {
                $this->addError('title', 'Title must be 5-25 chars');
            }
        }
    }

    private function validate_description()
    {

        $val = trim($this->data['description']);

        if (empty($val)) {
            $this->addError('description', 'Description cannot be empty');
        } else {
            if (!(strlen($val) < 100 && strlen($val) > 10)) {
                $this->addError('description', 'Description must be 10-100 chars & alphanumeric ');
            }
        }
    }

    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
