<?php
class CreateTicketHandler
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
        } else {
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
    {
        $contr = new Controller();
        $contr->create_ticket($this->post_data);
        //notify assigned developer
        $message = "assigned you to the ticket '{$this->post_data['title']}'";
        $contr->create_notification(2, $this->post_data['developer_assigned'], $message, $this->post_data['submitter']);
    }

    private function redirect()
    {
        echo "              
            <form action='project_details.php' method='post' id='form'>
                <input type='hidden' name='project_id' value='{$this->post_data['project_id']}'>
                <input type='hidden' name='requested_action' value='show_created_ticket_succes_message'>
                <input type='hidden' name='ticket_title' value='{$this->post_data['title']}'>
                <input type='hidden' name='ticket_description' value='{$this->post_data['description']}'>
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
