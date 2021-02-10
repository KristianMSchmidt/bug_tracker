<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');
include_once('../includes/shared/auto_loader.inc.php');

class CreateProjectHandler extends ProjectValidator
{
    public function __construct($data)
    {
        $this->new_project = $data;
        $this->contr = new Controller();
    }

    public function process_input()
    {
        $this->validate_title_and_description();
        session_start();
        $_SESSION['data'] = $this->new_project;
        if ($this->errors) {
            $_SESSION['errors'] = $this->errors;
            header('location:../views/create_project.php');
            exit();
        } else {
            $this->contr->create_project($this->new_project);
            $_SESSION['create_project_succes'] = true;
            header('location:../views/my_projects.php');
            exit();
        }
    }
}
