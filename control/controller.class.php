<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/php/repos/bugtracker/model/model.class.php');
/// document_root er 'opt/lampp/htdocs'

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

    public function get_user_by_name($full_name)
    {
        $results = $this->db_get_user_by_name($full_name);
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

    public function get_user_tickets_details($user_id, $role_name)
    {
        $results = $this->db_get_user_tickets_details($user_id, $role_name);

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
    public function check_project_name_unique($project_name, $project_id)
    {
        $results = $this->db_check_project_name_unique($project_name, $project_id);
        return $results;
    }

    public function check_ticket_title_unique($title, $ticket_id, $project_id)
    {
        $results = $this->db_check_ticket_title_unique($title, $ticket_id, $project_id);
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
    public function create_notification($notification_type_id, $info_id, $user_id, $created_by)
    {
        $this->db_create_notification($notification_type_id, $info_id, $user_id, $created_by);
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

    public function update_project($project_name, $project_description, $project_id)
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


    public function add_ticket_comment($user_id, $ticket_id, $comment)
    {

        $this->db_add_ticket_comment($user_id, $ticket_id, $comment);
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
            return "Not enrolled";
        }
    }

    public function get_ticket_id_by_title_and_project($ticket_title, $project_id)
    {
        $result = $this->db_get_ticket_id_by_title_and_project($ticket_title, $project_id);
        if (count($result) == 1) {
            return $result[0]['id'];
        }
    }

    public function get_user_project_ids($user_id, $role_name)
    {
        /* Method used to select the projects that are relevant for a given user (not necessarily just the projects they are enrolled in).
           Decides what projects will be shown in "My Projects" and to what projects the given user will have access to details.  

           Who have permission to a project?
          - All users should have permission to to details of the projects they are enrolled in
          - All users who have a ticket in a given project (as developer or submitter) should also have access to project details, 
            whether or not they are currently enrolled in the project (perhaps someone disenrolled them by accident)
         - Admins will get permission to all projects
        */

        if ($role_name == "Admin") {
            return ($this->db_get_all_project_ids());
        } else {
            return ($this->db_get_user_project_ids($user_id));
        }
    }

    public function check_project_details_permission($user_id, $role_name, $project_id)
    {
        if ($role_name == "Admin") {
            return true;
        } else {
            $projects = $this->get_user_project_ids($user_id, $role_name);
            foreach ($projects as $project) {
                if ($project['project_id'] == $project_id) {
                    return True;
                }
            }
        }
        return false;
    }

    public function get_project_details($project_array)
    {
        if (count($project_array) == 0) {
            return $project_array;
        } else {
            $id_array = [];
            foreach ($project_array as $project) {
                array_push($id_array, (string) $project['project_id']);
            }
            $details = $this->db_get_projects_details_from_project_id_array($id_array);
            return $details;
        }
    }

    public function get_user_projects_details($user_id, $role_name)
    {
        $projects = $this->get_user_project_ids($user_id, $role_name);
        return ($this->get_project_details($projects));
    }

    public function get_full_project_rights_ids($user_id, $role_name)
    // selects the ids of the projects to which the user has edit rights
    {
        if ($role_name == "Admin") {
            $projects = $this->db_get_all_project_ids();
        } else if (in_array($role_name, ["Submitter", "Project Manager"])) { //Submitter actually should not have all these rights, but only the right to add tickets to his projects
            $projects = $this->get_project_enrollments_by_user_id($_SESSION['user_id']);
        } else {
            $projects = [];
        }
        return $projects;
    }



    public function check_ticket_details_permission($user_id, $role_name, $ticket)
    {
        if (
            $role_name == "Admin" ||
            $ticket['developer_assigned_id'] == $user_id ||
            $ticket['submitter_id'] == $user_id
        ) {
            return true;
        } else if ($this->db_check_project_enrollment($user_id, $ticket['project_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
