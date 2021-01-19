<?php
/*
Only class direcly querying and modifying database. 

// user_by(property)
// project_by()
*/

class Controller extends Model
{
    public function get_users()
    {
        $results = $this->db_get_users();
        return $results;
    }

    public function get_user_by_id($user_id)
    {
        $result = $this->db_get_user_by_id($user_id);
        return $result;
    }

    public function get_user_by_email($email)
    {

        $results = $this->db_get_user_by_email($email);
        return $results;
    }

    public function get_most_busy_users()
    {
        $results = $this->db_get_most_busy_users();
        return $results;
    }

    public function get_users_by_role_id($role_id)
    {
        $results = $this->db_get_users_by_role_id($role_id);
        return $results;
    }

    public function set_user($full_name, $pwd, $email, $role_id)
    {
        $this->db_set_user($full_name, $pwd, $email, $role_id);
    }

    public function get_projects_by_user_id($user_id, $role_name)
    {

        $results = $this->db_get_projects_by_user_id($user_id, $role_name);
        return $results;
    }

    public function get_tickets_by_user($user_id, $role_name)
    {
        $results = $this->db_get_tickets_by_user($user_id, $role_name);

        return $results;
    }

    public function get_ticket_priority_count()
    {
        $results = $this->db_get_ticket_priority_count();
        return $results;
    }

    public function get_ticket_status_count()
    {
        $results = $this->db_get_ticket_status_count();
        return $results;
    }

    public function get_tickets_type_count()
    {
        $results = $this->db_get_tickets_type_count();
        return $results;
    }

    public function get_notifications_by_user_id($user_id)
    {
        $notifications = $this->db_get_notifications_by_user_id($user_id);

        $unseen = 0;
        foreach ($notifications as $notification) {
            $unseen += $notification['unseen'];
        }
        return  array('notifications' => $notifications, 'num_unseen' => $unseen);
    }

    public function make_notifications_seen($user_id)
    {
        $this->db_make_notifications_seen($user_id);
    }

    public function set_session($user_id, $session_id)
    {
        $this->db_set_session($user_id, $session_id);
    }
}
