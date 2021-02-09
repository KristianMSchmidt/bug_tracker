<?php
class AddCommentHandler
{
    private $ticket_id;
    private $comment;
    private $errors = [];

    public function __construct($post_data)
    {
        $this->comment = trim($post_data['new_comment']);
        $this->ticket_id = $post_data['ticket_id'];
    }

    public function process_input()
    {
        session_start();

        $this->validate_comment();

        if (!$this->errors) {
            $this->save_comment();
        } else {
            $_SESSION['errors'] = $this->errors;
        }
        header("location: ../views/ticket_details.php?ticket_id={$this->ticket_id}");
    }


    private function validate_comment()
    {

        $val = $this->comment;

        if (empty($val)) {
            $this->add_error('comment', 'Your comment has no content');
        } else {
            if (!(strlen($val) > 5 && strlen($val) < 201)) {
                $this->add_error('comment', 'Your comment must be 5-200 chars');
            }
        }
    }

    private function save_comment()
    {
        include_once('shared/auto_loader.inc.php');
        $contr = new Controller();
        $contr->add_ticket_comment($_SESSION['user_id'], $this->ticket_id, $this->comment);
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
