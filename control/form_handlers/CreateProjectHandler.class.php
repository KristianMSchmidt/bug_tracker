<?php
require_once('form_handlers/ProjectValidator.class.php');
require_once('controller.class.php');

class CreateProjectHandler extends ProjectValidator
{
    public function __construct($data)
    {
        $this->new_project = $data;
        $this->contr = new Controller();
    }

    public function create_project()
    {
        $this->validate_title_and_description();
        if (!$this->errors) {
            $this->contr->create_project($this->new_project);
        }
        return $this->errors;
    }
}
