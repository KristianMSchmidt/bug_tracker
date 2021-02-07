<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class CreateProjectHandler extends ProjectValidator
{
    public function process_input()
    {
        $this->validate_title_and_description('create');

        if (!$this->errors) {
            $this->create();
            $this->redirect();
        } else {
            return $this->errors;
        }
    }

    private function create()
    {
        $this->contr->create_project($this->new_project);
    }

    private function redirect()
    {
        echo "              
            <form action='my_projects.php' method='post' id='form'>
                <input type='hidden' name='project_title' value='{$this->new_project['title']}'>
                <input type='hidden' name='project_description' value='{$this->new_project['description']}'>
                <input type='hidden' name='show_created_project_succes_message'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>
            ";
    }
}
