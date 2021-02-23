<?php
require_once('form_handlers/ProjectValidator.class.php');
require_once('controller.class.php');

class EditProjectHandler extends ProjectValidator
{
    public function __construct($post_data)
    {
        $this->new_project = $post_data;
        $this->project_id = $post_data['project_id'];
        $this->contr = new Controller();
        $this->old_project = $this->contr->get_project_by_id($this->project_id, -1);
    }

    public function edit_project()
    {
        $this->check_all_errors();
        if (!$this->errors) {
            $this->contr->update_project($this->new_project['project_name'], $this->new_project['project_description'], $this->project_id);
        }
        return $this->errors;
    }

    private function check_all_errors()
    {
        $this->validate_title_and_description();
        if (!$this->errors) {
            $this->validate_changes_made();
        }
    }

    private function validate_changes_made()
    {
        $changes = False;

        if ($this->old_project['project_name'] !== $this->new_project['project_name']) {
            $changes = True;
        }
        if ($this->old_project['project_description'] !== $this->new_project['project_description']) {
            $changes = True;
        }
        if (!$changes) {
            $this->add_error('no_changes_error', 'No changes made to project');
        }
    }
}
