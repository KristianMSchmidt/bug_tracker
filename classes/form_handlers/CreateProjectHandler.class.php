<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class CreateProjectHandler extends ProjectValidator
{
    public function __construct($data)
    {
        $this->new_project = $data;
    }

    public function process_input()
    {
        $this->validate_title_and_description('create');
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



/* Note to self:
   The redirects above are essential for the Post Redirect Get (PRG) design pattern. 
   Without the redirects, the site works poorly (backbutton causes error messages) and is considered unsafe. 

*/
