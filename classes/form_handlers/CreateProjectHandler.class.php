<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class CreateProjectHandler extends ProjectValidator
{
    public function process_input()
    {
        $this->validate_title_and_description('create');
        $_SESSION['post_data'] = $this->new_project;
        if ($this->errors) {
            $_SESSION['errors'] = $this->errors;
            header('location:create_project.php');
        } else {
            $this->contr->create_project($this->new_project);
            header('location:my_projects.php');
            return $this->errors;
        }
    }
}



/* Note to self:
   The redirects above are essential for the Post Redirect Get (PRG) design pattern. 
   Without the redirects, the site works poorly (backbutton causes error messages) and is considered unsafe. 

*/
