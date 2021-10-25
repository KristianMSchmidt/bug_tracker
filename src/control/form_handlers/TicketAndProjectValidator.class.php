<?php

class TicketAndProjectValidator
{
    protected function validate_title_length($title, $type)
    {
        $title = trim($title);
        if (empty($title)) {
            $this->add_error('title', "{$type} needs a title");
        } else if (strlen($title) < 6 || strlen($title) > 40) {
            $this->add_error('title', "Title must be 6-40 chars");
        }
    }

    protected function validate_description($description, $type)
    {

        $description = trim($description);
        if (empty($description)) {
            $this->add_error('description', "{$type} needs a description");
        } else if (strlen($description) < 6 || strlen($description) > 200) {
            $this->add_error('description', 'Description must be 6-200 chars');
        }
    }

    protected function add_error($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
