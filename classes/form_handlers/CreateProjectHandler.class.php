<?php

class CreateProjectHandler
{
    private $post_data;
    private $errors = [];

    public function __construct($post_data)
    {
        $this->post_data = $post_data;
    }

    public function process_input()
    {
        $this->validate_title();
        $this->validate_description();

        if (!$this->errors) {
            $this->create();
            $this->redirect();
        }
        else{
            return $this->errors;
        }
    }

    private function validate_title()
    {

        $val = trim($this->post_data['title']);

        if (empty($val)) {
            $this->add_error('title', 'Ticket needs a title');
        } else {
            if (!(strlen($val) < 45 && strlen($val) > 5)) {
                $this->add_error('title', 'Title must be 6-45 chars');
            }
        }
    }

    private function validate_description()
    {

        $val = trim($this->post_data['description']);

        if (empty($val)) {
            $this->add_error('description', 'Ticket needs a description');
        } else {
            if (!(strlen($val) < 300 && strlen($val) > 5)) {
                $this->add_error('description', 'Description must be 6-300 chars');
            }
        }
    }

    private function create()
    {   include_once('../includes/auto_loader.inc.php');
        $contr = new Controller();
        $contr->create_project($this->post_data);
        //notify assigned developer
        
    }

    private function redirect()
    {
        echo "              
            <form action='my_projects.php' method='post' id='form'>
                <input type='hidden' name='project_title' value='{$this->post_data['title']}'>
                <input type='hidden' name='show_created_project_succes_message'>
            </form>
            <script>
                document.getElementById('form').submit();
            </script>
            ";
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
/*
$x=new CreateProjectHandler(array('title'=>1, 'description'=>4));
$errors = $x->process_input();
print_r($errors);
*/