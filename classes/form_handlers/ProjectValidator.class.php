<?php
include_once('../classes/form_handlers/TicketAndProjectValidator.class.php');

class ProjectValidator extends TicketAndProjectValidator
{
    protected $new_project;
    protected $errors = [];
    protected $contr;

    protected function validate_title_unique($type)
    {
        include_once('../includes/shared/auto_loader.inc.php');
        $this->contr = new Controller();
        $potential_other_project = $this->contr->get_project_by_title(trim($this->new_project['project_name']));
        if ($potential_other_project) {
            if ($type == 'create' || ($type == 'edit' && ($potential_other_project['project_id'] !== $this->new_project['project_id']))) {
                $this->add_error('title', 'There is already a project by that name');
            }
        }
    }

    protected function validate_title_and_description($type)
    {
        $this->validate_title_length($this->new_project['project_name'], 'Project');

        if (!$this->errors) {
            $this->validate_title_unique($type);
        }
        $this->validate_description($this->new_project['project_description'], 'Project');
    }
}
