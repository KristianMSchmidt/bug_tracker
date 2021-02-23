<?php
require_once('form_handlers/TicketAndProjectValidator.class.php');

class ProjectValidator extends TicketAndProjectValidator
{
    protected $new_project;
    protected $old_project = 'undefined';
    protected $project_id = 'undefined';
    protected $errors = [];
    protected $contr;

    protected function validate_title_unique()
    {
        //check if there already is already another project with the chosen new name
        $other_project_same_title = $this->contr->check_project_name_unique(trim($this->new_project['project_name']), $this->project_id);
        if ($other_project_same_title) {
            $this->add_error('title', 'There is already a project by that name in the database');
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
