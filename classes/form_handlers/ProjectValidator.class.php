<?php
include_once('../classes/form_handlers/TicketAndProjectValidator.class.php');

class ProjectValidator extends TicketAndProjectValidator
{
    protected $new_project;
    protected $old_project = 'undefined';
    protected $project_id = 'undefined';
    protected $errors = [];
    protected $contr;

    protected function validate_title_unique()
    {
        //check if there already is another project with the chosen new name
        $potential_other_project = $this->contr->get_project_by_title(trim($this->new_project['project_name']));
        if ($potential_other_project && ($potential_other_project['project_id'] !== $this->project_id)) {
            $this->add_error('title', 'There is already a project by that name');
        }
    }

    protected function validate_title_and_description()
    {
        $this->validate_title_length($this->new_project['project_name'], 'Project');

        if (!$this->errors) {
            $this->validate_title_unique();
        }
        $this->validate_description($this->new_project['project_description'], 'Project');
    }
}
