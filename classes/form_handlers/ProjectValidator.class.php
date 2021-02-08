<?php
include_once('../classes/form_handlers/TicketAndProjectValidator.class.php');

class ProjectValidator extends TicketAndProjectValidator
{
    protected $new_project;
    protected $old_project;
    protected $project_id;
    protected $errors = [];
    protected $contr;

    protected function validate_title_unique($type)
    {
        $title = trim($this->new_project['title']);
        include_once('../includes/auto_loader.inc.php');
        $contr = new Controller();
        $this->contr = $contr;
        $title = $contr->get_project_by_title($title);
        if ($title) {
            if ($type == 'create' || ($type == 'edit' && ($title['project_name'] !== $this->new_project['title']))) {
                $this->add_error('title', 'There is already a project by that name');
            }
        }
    }

    protected function validate_title_and_description($type)
    {
        $this->validate_title_length($this->new_project['title'], 'Project');
        if (!$this->errors) {
            $this->validate_title_unique($type);
        }
        $this->validate_description($this->new_project['description'], 'Project');
    }
}
