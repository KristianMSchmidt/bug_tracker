<?php

class AddCommentHandler
{
    private $comment;
    private $developer_assigned_id;
    private $errors = [];
    private $user_id;

    public function __construct($post_data, $user_id)
    {
        $this->comment = trim($post_data['new_comment']);
        $this->developer_assigned_id = $post_data['developer_assigned_id'];
        $this->ticket_id = $post_data['ticket_id'];
        $this->user_id = $user_id;
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
        require_once('controller.class.php');
        $contr = new Controller();
        $contr->add_ticket_comment($this->user_id, $this->ticket_id, $this->comment);

        //Nofity the assigned developer, is it is not the develop himself writing this comment
        if ($this->developer_assigned_id !== $this->user_id) {
            $notification_type_id = 6;
            $contr->create_notification($notification_type_id, $this->ticket_id, $this->developer_assigned_id, $this->user_id);
        }
    }

    private function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
