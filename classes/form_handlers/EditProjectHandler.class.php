<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class EditProjectHandler extends ProjectValidator
{

    public function __construct($post_data)
    {
        $this->new_project = $post_data['new_project'];
        if (isset($post_data['old_project'])) {
            $this->old_project = $post_data['old_project'];
        }
        if (isset($post_data['project_id'])) {
            $this->project_id = $post_data['project_id'];
        }
    }

    public function process_input()
    {
        $this->validate_title_and_description('edit');

        if (!$this->errors) {
            $this->validate_changes_made();
        }
        if (!$this->errors) {
            $this->edit();
            $this->redirect();
        }
        return $this->errors;
    }

    private function validate_changes_made()
    {
        $changes = False;

        if ($this->old_project['title'] !== $this->new_project['title']) {
            $changes = True;
        }
        if ($this->old_project['description'] !== $this->new_project['description']) {
            $changes = True;
        }
        if (!$changes) {
            $this->add_error('no_changes_error', 'No changes made to project');
        }
    }

    private function edit()
    {
        $this->contr->set_project($this->new_project['title'], $this->new_project['description'], $this->project_id);
    }

    private function redirect()
    {
        echo "              
            <form action='project_details.php' method='post' id='form'>
                <input type='hidden' name='project_id' value='{$this->project_id}'>
                <input type='hidden' name='show_project_edited_succes_message'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>";
    }
}
