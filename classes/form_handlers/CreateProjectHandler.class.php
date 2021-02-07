<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class CreateProjectHandler extends ProjectValidator
{
    public function process_input()
    {
        $this->validate_title_length($this->post_data['title'], 'Project');
        if (!$this->errors) {
            $this->validate_title_unique();
        }
        $this->validate_description($this->post_data['description'], 'Project');

        if (!$this->errors) {
            $this->create();
            $this->redirect();
        } else {
            return $this->errors;
        }
    }

    private function create()
    {
        $this->contr->create_project($this->post_data);
    }

    private function redirect()
    {
        echo "              
            <form action='my_projects.php' method='post' id='form'>
                <input type='hidden' name='project_title' value='{$this->post_data['title']}'>
                <input type='hidden' name='project_description' value='{$this->post_data['description']}'>
                <input type='hidden' name='show_created_project_succes_message'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>
            ";
    }
}
