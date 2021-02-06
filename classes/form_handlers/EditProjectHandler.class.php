<?php
class EditProjectHandler
{
    private $old_project_name;
    private $old_project_description;
    private $new_project_name;
    private $new_project_description;
    private $project_id;
    private $errors = [];

    public function __construct($post_data)
    {
        $this->old_project_name = trim($post_data['old_project_name']);
        $this->old_project_descrition = trim($post_data['old_project_description']);
        $this->new_project_name = trim($post_data['new_project_name']);
        $this->new_project_description = trim($post_data['new_project_description']);
        $this->project_id = $post_data['project_id'];
    }

    public function process_input()
    {
        $this->validate_title();
        $this->validate_description();

        if (!$this->errors) {
            $this->attempt_edit();
        }

        if (!$this->errors) {
            $this->redirect();
        }

        return $this->errors;
    }

    private function validate_title()
    {

        $val = $this->new_project_name;

        if (empty($val)) {
            $this->add_error('title', 'Project needs a title');
        } else {
            if (!(strlen($val) < 31 && strlen($val) > 5)) {
                $this->add_error('title', 'Title must be 6-30 chars');
            }
        }
    }

    private function validate_description()
    {

        $val = $this->new_project_description;

        if (empty($val)) {
            $this->add_error('description', 'Project needs a description');
        } else {
            if (!(strlen($val) < 201 && strlen($val) > 5)) {
                $this->add_error('description', 'Description must be 6-200 chars');
            }
        }
    }

    private function attempt_edit()
    {
        $changes = False;
        $contr = new Controller();

        if ($this->old_project_name != $this->new_project_name) {
            $changes = True;
        }
        if ($this->old_project_description != $this->new_project_description) {
            $changes = True;
        }
        if (!$changes) {
            $this->add_error('no_changes_error', 'No changes made to ticket');
        } else {
            $contr = new Controller();
            $contr->set_project($this->new_project_name, $this->new_project_description, $this->project_id);
        }
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

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
