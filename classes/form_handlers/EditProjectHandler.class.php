<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class EditProjectHandler extends ProjectValidator
{
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
                <input type='hidden' name='requested_action' value='show_project_edited_succes_message'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>";
    }
}
