<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/php/repos/bug_tracker/model/model.class.php');

class Controller extends Model
{
    /*

    Public interface for the model class. 
    
    */

    public function get_users($user_id)
    {
        $results = $this->db_get_users($user_id);
        return $results;
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

    public function create_user($full_name, $pwd, $email, $role_id)
    {
        $this->db_create_user($full_name, $pwd, $email, $role_id);
    }

    public function get_projects_by_user($user_id, $role_name)
    {
        $projects = $this->db_get_projects_by_user($user_id, $role_name);
        return $projects;
    }

    public function get_tickets_by_user_and_role($user_id, $role_name)
    {
        $results = $this->db_get_tickets_by_user_and_role($user_id, $role_name);

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
        return $this->db_get_tickets_type_count();
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

    public function update_role($role_id, $updater, $user_id)
    {
        $this->db_update_role($role_id, $updater, $user_id);
    }

    public function get_project_by_id($project_id)
    {
        $results = $this->db_get_project_by_id($project_id);
        return $results;
    }
    public function get_project_users($project_id, $role_id)
    {
        $results = $this->db_get_project_users($project_id, $role_id);
        return $results;
    }
    public function get_project_by_title($project_name)
    {
        $results = $this->db_get_project_by_title($project_name);
        return $results;
    }

    public function get_ticket_by_title($title)
    {
        $results = $this->db_get_ticket_by_title($title);
        return $results;
    }

    public function get_users_not_enrolled_in_project($project_id)
    {
        $results = $this->db_get_users_not_enrolled_in_project($project_id);
        return $results;
    }
    public function get_tickets_by_project($project_id)
    {
        $results = $this->db_get_tickets_by_project($project_id);
        return $results;
    }
    public function create_notification($notification_type, $user_id, $message, $created_by)
    {
        $this->db_create_notification($notification_type, $user_id, $message, $created_by);
    }

    public function get_ticket_by_id($ticket_id)
    {
        $ticket = $this->db_get_ticket_by_id($ticket_id);
        return $ticket;
    }

    public function get_projects()
    {
        $projects = $this->db_get_projects();
        return $projects;
    }

    public function get_priorities()
    {
        $priorities = $this->db_get_priorities();
        return $priorities;
    }

    public function get_ticket_types()
    {
        $ticket_types = $this->db_get_ticket_types();
        return $ticket_types;
    }

    public function get_ticket_status_types()
    {
        $ticket_status_types = $this->db_get_ticket_status_types();
        return $ticket_status_types;
    }

    public function update_ticket($data)
    {
        $this->db_update_ticket($data);
    }

    public function set_update($project_name, $project_description, $project_id)
    {
        $this->db_update_project($project_name, $project_description, $project_id);
    }

    public function get_role_name_by_role_id($role_id)
    {
        return $this->db_get_role_name_by_role_id($role_id);
    }

    public function add_to_ticket_events($ticket_id, $event_type, $old_value, $new_value)
    {
        $this->db_add_to_ticket_events($ticket_id, $event_type, $old_value, $new_value);
    }

    public function get_ticket_events($ticket_id)
    {
        return $this->db_get_ticket_events($ticket_id);
    }

    public function get_ticket_comments($ticket_id)
    {
        return $this->db_get_ticket_comments($ticket_id);
    }

    public function get_project_name_by_id($project_id)
    {

        return $this->db_get_project_name_by_id($project_id);
    }

    public function get_priority_name_by_id($priority_id)
    {

        return $this->db_get_priority_name_by_id($priority_id);
    }

    public function get_ticket_type_name_by_id($type_id)
    {

        return $this->db_ticket_type_name_by_id($type_id);
    }


    public function get_ticket_status_name_by_id($status_id)
    {

        return $this->db_ticket_status_name_by_id($status_id);
    }


    public function add_ticket_comment($user_id, $ticket_id, $message)
    {

        $this->db_add_ticket_comment($user_id, $ticket_id, $message);
    }

    public function create_ticket($data)
    {
        $this->db_create_ticket($data);
    }

    public function create_project($data)
    {
        $this->db_create_project($data);
    }

    public function assign_to_project($user_id, $project_id)
    {
        $this->db_assign_to_project($user_id, $project_id);
    }

    public function unassign_from_project($user_id, $project_id)
    {
        $this->db_unassign_from_project($user_id, $project_id);
    }

    public function get_project_enrollments_by_user_id($user_id)
    {
        return ($this->db_get_project_enrollments_by_user_id($user_id));
    }

    public function get_enrollment_start_by_user_and_project($project_id, $user_id)
    {

        $result = $this->db_get_enrollment_start_by_user_and_project($project_id, $user_id);
        if (count($result) == 1) {
            return $result[0]['enrollment_start'];
        } else if (count($result) == 0) {
            return "Not personally enrolled";
        }
    }
}
