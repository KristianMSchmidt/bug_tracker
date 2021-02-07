<?php
include_once('../classes/form_handlers/TicketAndProjectValidator.class.php');

class ProjectValidator extends TicketAndProjectValidator
{
    protected $post_data;
    protected $errors = [];
    protected $contr;

    public function __construct($post_data)
    {
        $this->post_data = $post_data;
    }

    protected function validate_title_unique()
    {
        $title = trim($this->post_data['title']);
        include_once('../includes/auto_loader.inc.php');
        $contr = new Controller();
        $this->contr = $contr;
        if ($contr->get_project_by_title($title)) {
            $this->add_error('title', 'There is already a project by that name');
        }
    }
}
