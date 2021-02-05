<?php
class AddCommentHandler
{
    private $user_id;
    private $ticket_id;
    private $comment;
    private $errors = [];

    public function __construct($user_id, $ticket_id, $post_data)
    {
        $this->user_id = $user_id;
        $this->ticket_id = $ticket_id;
        $this->comment = trim($post_data['new_comment']);
    }

    public function process_input()
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
            if (!(strlen($val) > 5 && strlen($val) < 200)) {
                $this->add_error('comment', 'Your comment must be 5-200 chars');
            }
        }
    }

    private function save_comment()
    {
        $contr = new controller();
        $contr->add_ticket_comment($this->user_id, $this->ticket_id, $this->comment);
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
