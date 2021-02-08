<?php
include_once('../classes/form_handlers/ProjectValidator.class.php');

class EditProjectHandler extends ProjectValidator
{
    private $old_project;
    private $project_id;

    public function __construct($data)
    {
        $this->new_project = $data;
        $this->project_id = $data['project_id'];
    }

    public function process_input()
    {
        $this->check_all_errors();

        if ($this->errors) {
            $_SESSION['errors'] = $this->errors;
            $_SESSION['data'] = $this->new_project;
            header('location:edit_project.php');
            exit();
        } else {
            $this->contr->set_project($this->new_project['project_name'], $this->new_project['project_description'], $this->project_id);
            $_SESSION['edit_project_succes'] = true;
            header("location:project_details.php?project_id={$this->new_project['project_id']}");
            exit();
        }
    }

    private function check_all_errors()
    {
        $this->validate_title_and_description('edit');
        if (!$this->errors) {
            $this->validate_changes_made();
        }
    }

    private function validate_changes_made()
    {
        $this->old_project = $this->contr->get_project_by_id($this->project_id);

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
