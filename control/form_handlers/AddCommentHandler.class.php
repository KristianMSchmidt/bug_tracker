<?php
class AddCommentHandler
{
    private $comment;
    private $errors = [];

    public function __construct($post_data)
    {
        $this->comment = trim($post_data['new_comment']);
        $this->ticket_id = $post_data['ticket_id'];
    }

    public function add_comment()
    {
        $this->validate_comment();
        if (!$this->errors) {
            $this->save_comment();
        }
        return $this->errors;
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
        include_once('../controller.class.php');
        $contr = new Controller();
        $contr->add_ticket_comment($_SESSION['user_id'], $this->ticket_id, $this->comment);
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
