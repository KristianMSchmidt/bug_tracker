<?php
/*
This is the only class direcly querying and modifying database. Only protected methods.
*/

class Model extends Dbh
{
    protected function db_get_users()
    {
        $sql  = "SELECT * 
                 FROM users JOIN user_roles
                 ON users.role_id = user_roles.role_id
                 ORDER by users.full_name";
        $stmt = $this->connect()->query($sql); //stmt is a "PDO Stamement Object"
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function db_get_user_by_id($user_id)
    //to do: refactor db_get_user_by_property('user_id')
    {
        $sql = "SELECT * 
             FROM users JOIN user_roles
             ON users.role_id = user_roles.role_id 
             WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]); //stmt is a "PDO Stamement Object"
        $result = $stmt->fetch();
        return $result;
    }

    protected function db_get_user_by_email($email)
    {
        $sql = "SELECT * 
                FROM users JOIN user_roles
                ON users.role_id = user_roles.role_id 
                WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]); //stmt is a "PDO Stamement Object"
        $results = $stmt->fetch();
        return $results;
    }

    protected function db_get_most_busy_users()
    {
        $sql = "SELECT COUNT(tickets.ticket_id) as count, users.full_name
        FROM tickets 
        LEFT JOIN users ON tickets.developer_assigned = users.user_id    
        WHERE tickets.status = 1
        GROUP BY tickets.developer_assigned
        ORDER BY count(tickets.ticket_id) ASC LIMIT 5";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_users_by_role_id($role_id)
    {
        $sql  = "SELECT *
                FROM users
                WHERE role_id = {$role_id}";
        $stmt = $this->connect()->query($sql);
        $results = $stmt->fetchAll();
        return $results;
    }


    protected function db_set_user($full_name, $pwd, $email, $role_id)
    {

        $sql = "INSERT INTO users(full_name, password, email, role_id)
                VALUES(?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$full_name, $pwd, $email, $role_id]);
    }

    protected function db_get_projects_by_user_id($user_id, $role_name)
    {
        $sql = "SELECT 
                projects.project_id,
                projects.project_name,
                projects.project_description
                FROM projects";

        if ($role_name != 'Admin') {
            $sql .= " WHERE projects.project_id IN 
                    (SELECT project_id 
                    FROM project_enrollments 
                    WHERE user_id = {$user_id})";
        }

        $sql .=  " ORDER BY created_at DESC";

        $stmt = $this->connect()->query($sql);
        $results = $stmt->fetchAll();
        return $results;
    }
    protected function db_get_tickets_by_user($user_id, $role_name)
    {
        $sql =
            "SELECT 
           tickets.title,
           tickets.ticket_id,
           tickets.created_at,
           projects.project_name,
           ticket_priorities.ticket_priority_name,
           ticket_status_types.ticket_status_name,
           ticket_types.ticket_type_name,
           s.full_name AS submitter_name,  /* alias necessary */
           d.full_name AS developer_name  /* alias necessary */
           FROM tickets 
           LEFT JOIN users s ON tickets.submitter = s.user_id
           LEFT JOIN users d ON tickets.developer_assigned = d.user_id
           JOIN projects ON tickets.project = projects.project_id
           JOIN ticket_status_types ON tickets.status = ticket_status_types.ticket_status_id
           JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id
           JOIN ticket_types ON tickets.type =ticket_types.ticket_type_id";

        // add conditions to sql depending on user type
        if ($role_name == 'Project Manager') :
            $sql .= " WHERE tickets.project IN 
              (SELECT project_id FROM project_enrollments WHERE user_id = ?)";

        elseif ($role_name == 'Developer') :
            $sql .= " WHERE tickets.developer_assigned = ?";

        elseif ($role_name == 'Submitter') :
            $sql .= " WHERE tickets.submitter = ?";

        endif;

        // latest project at top
        $sql .= " ORDER BY tickets.created_at DESC";

        $stmt = $this->connect()->prepare($sql);

        if ($role_name == 'Admin') :
            $stmt->execute();
        else :
            $stmt->execute([$user_id]);
        endif;

        $results = $stmt->fetchAll();

        return $results;
    }

    protected function db_get_ticket_priority_count()
    {
        $sql = "SELECT COUNT(tickets.ticket_id) AS count, 
                ticket_priorities.ticket_priority_name 
                FROM tickets RIGHT JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id 
                GROUP BY ticket_priorities.ticket_priority_id ORDER BY ticket_priorities.ticket_priority_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_ticket_status_count()
    {

        $sql = "SELECT COUNT(tickets.ticket_id) 
                AS count, ticket_status_types.ticket_status_name 
                FROM tickets RIGHT JOIN ticket_status_types 
                ON tickets.status = ticket_status_types.ticket_status_id
                GROUP BY ticket_status_types.ticket_status_id 
                ORDER BY ticket_status_types.ticket_status_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_tickets_type_count()
    {
        $sql = "SELECT 
                COUNT(tickets.ticket_id),
                ticket_types.ticket_type_name 
                FROM tickets RIGHT JOIN ticket_types ON tickets.type = ticket_types.ticket_type_id
                GROUP BY ticket_types.ticket_type_id ORDER BY ticket_types.ticket_type_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_notifications_by_user_id($user_id)
    {
        $sql = "SELECT 
                    notifications.unseen, 
                    notifications.message,
                    notifications.created_at, 
                    notifications.user_id, 
                    notification_types.notification_type_id as type, 
                    users.full_name as created_by
                FROM notifications
                JOIN notification_types ON notifications.notification_type = notification_types.notification_type_id
                LEFT JOIN users ON notifications.created_by = users.user_id
                WHERE notifications.user_id = ?
                ORDER BY notification_id DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $notifications = $stmt->fetchAll();
        return $notifications;
    }

    protected function db_make_notifications_seen($user_id)
    {
        $sql = "UPDATE notifications SET unseen = 0 WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
    }

    protected function db_set_session($user_id, $session_id)
    {
        $sql = "INSERT INTO sessions(user_id, session_id_php) VALUES(?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $session_id]);
    }

    protected function db_set_role($user_id, $role_id)
    {
        $sql = "UPDATE users SET role_id = ? WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role_id, $user_id]);
    }

    protected function db_get_project_by_id($project_id)
    {
        $sql = "SELECT * FROM projects WHERE project_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $project = $stmt->fetch();
        return $project;
    }

    public function db_get_project_by_title($project_name)
    {
        $sql = "SELECT project_name FROM projects WHERE project_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([trim($project_name)]);
        $result = $stmt->fetch();
        return $result;
    }

    public function db_get_ticket_by_title($ticket_name, $project_id)
    {
        $sql = "SELECT title 
                FROM tickets 
                WHERE title = ? AND project =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_name, $project_id]);
        $project = $stmt->fetch();
        return $project;
    }



    protected function db_get_project_users($project_id)
    //all users assigned to project
    {
        $sql =
            "SELECT users.full_name, users.email, user_roles.role_name, users.user_id
            FROM users 
            JOIN project_enrollments ON users.user_id = project_enrollments.user_id
            JOIN user_roles ON user_roles.role_id = users.role_id
            WHERE project_enrollments.project_id = ?
            ORDER BY users.full_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $users = $stmt->fetchAll();
        return $users;
    }

    protected function db_get_users_not_enrolled_in_project($project_id)
    {
        $sql =
            "SELECT users.full_name, users.user_id, user_roles.role_name
            FROM users 
            JOIN user_roles ON user_roles.role_id = users.role_id
            WHERE users.user_id NOT IN 
                (SELECT user_id FROM `project_enrollments` WHERE project_id=?)
            ORDER BY users.full_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $users = $stmt->fetchAll();
        return $users;
    }

    protected function db_get_tickets_by_project($project_id)
    //all tickets to given project
    // TODO: merge this function with db_get_tickets_by_id
    {
        $sql = "SELECT
        tickets.ticket_id,
        tickets.title,
        tickets.created_at,
        ticket_priorities.ticket_priority_name,
        ticket_status_types.ticket_status_name,
        ticket_types.ticket_type_name,
        s.full_name AS submitter_name,  /* alias necessary */
        d.full_name AS developer_name   /* alias necessary */
        FROM tickets 
        LEFT JOIN users s ON tickets.submitter = s.user_id
        LEFT JOIN users d ON tickets.developer_assigned = d.user_id
        JOIN projects ON tickets.project = projects.project_id
        JOIN ticket_status_types ON tickets.status = ticket_status_types.ticket_status_id
        JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id
        JOIN ticket_types ON tickets.type =ticket_types.ticket_type_id
        WHERE tickets.project = ?
        ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $tickets = $stmt->fetchAll();
        return $tickets;
    }

    protected function db_get_ticket_by_id($ticket_id)
    {
        $sql = "SELECT
        tickets.ticket_id,
        tickets.type,
        tickets.status,
        tickets.priority,
        tickets.developer_assigned,
        tickets.submitter,
        tickets.project,
        tickets.title,
        tickets.description,
        tickets.created_at,
        tickets.updated_at,
        ticket_priorities.ticket_priority_name,
        ticket_status_types.ticket_status_name,
        ticket_types.ticket_type_name,
        projects.project_name,
        s.full_name AS submitter_name,  /* alias necessary */
        d.full_name AS developer_name   /* alias necessary */
        FROM tickets 
        /* left join er vigtig her, da der stadig skal findes resultater frem fra tickets,
         selvom f.eks. submitteren i mellemtiden er blevet slettet        
        */
        LEFT JOIN users s ON tickets.submitter = s.user_id
        LEFT JOIN users d ON tickets.developer_assigned = d.user_id
        JOIN projects ON tickets.project = projects.project_id
        JOIN ticket_status_types ON tickets.status = ticket_status_types.ticket_status_id
        JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id
        JOIN ticket_types ON tickets.type =ticket_types.ticket_type_id
        WHERE tickets.ticket_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id]);
        $tickets = $stmt->fetch();
        return $tickets;
    }


    protected function db_create_notification($notification_type, $user_id, $message, $created_by)
    {
        $sql = "INSERT INTO notifications(notification_type, user_id, message, unseen, created_by) VALUES(?, ?, ?, ?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$notification_type, $user_id, $message, 1, $created_by]);
    }

    protected function db_add_to_ticket_history($ticket_id, $event_type, $old_value, $new_value)
    {
        $sql = "INSERT INTO ticket_history(ticket_id, event_type, old_value, new_value) VALUES (?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id, $event_type, $old_value, $new_value]);
    }

    protected function db_get_projects()
    //All projects
    {
        $sql = "SELECT project_id, project_name FROM projects";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $projects = $stmt->fetchAll();
        return $projects;
    }


    protected function db_get_priorities()
    //All priority names and their id's
    {
        $sql = "SELECT ticket_priority_id, ticket_priority_name FROM ticket_priorities";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $priorities = $stmt->fetchAll();
        return $priorities;
    }

    protected function db_get_ticket_types()
    {
        $sql = "SELECT ticket_type_id, ticket_type_name FROM ticket_types";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $types = $stmt->fetchAll();
        return $types;
    }

    protected function db_get_ticket_status_types()
    //All status names and their id's
    {
        $sql = "SELECT ticket_status_id, ticket_status_name FROM ticket_status_types";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $status_types = $stmt->fetchAll();
        return $status_types;
    }

    protected function db_set_ticket($data)
    {

        $sql = "UPDATE tickets 
                SET 
                    title = ?,
                    project = ?,
                    developer_assigned = ?,
                    priority=?,
                    status = ?,
                    type=?,
                    description=?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE ticket_id = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $data['title'],
            $data['project'],
            $data['developer_assigned'],
            $data['priority'],
            $data['status'],
            $data['type'],
            $data['description'],
            $data['ticket_id']
        ]);
    }


    protected function db_set_project($project_title, $project_description, $project_id)
    {

        $sql = "UPDATE projects 
                SET 
                    project_name = ?,
                    project_description = ?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE project_id = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_title, $project_description, $project_id]);
    }


    protected function db_get_role_name_by_role_id($role_id)
    {
        $sql = "SELECT role_name 
                FROM user_roles
                WHERE role_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role_id]);
        $role_name = $stmt->fetch();
        return $role_name;
    }

    protected function db_get_ticket_history($ticket_id)
    {
        $sql = "SELECT * 
                FROM ticket_history 
                WHERE ticket_id = ?
                ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id]);
        $ticket_history = $stmt->fetchAll();
        return $ticket_history;
    }

    protected function db_get_ticket_comments($ticket_id)
    {
        $sql = "SELECT 
                    ticket_comments.message, 
                    ticket_comments.created_at,
                    users.full_name as commenter
                FROM ticket_comments
                LEFT JOIN users on ticket_comments.commenter_user_id = users.user_id
                WHERE ticket_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id]);
        $comments = $stmt->fetchAll();
        return $comments;
    }


    protected function db_get_project_name_by_id($project_id)
    {
        $sql = "SELECT project_name 
                FROM projects 
                WHERE project_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $project_name = $stmt->fetch();
        return $project_name;
    }

    protected function db_get_priority_name_by_id($priority_id)
    {
        $sql = "SELECT ticket_priority_name 
                FROM ticket_priorities
                WHERE ticket_priority_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$priority_id]);
        $result = $stmt->fetch();
        return $result;
    }

    protected function db_ticket_type_name_by_id($type_id)
    {
        $sql = "SELECT ticket_type_name
                FROM ticket_types
                WHERE ticket_type_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$type_id]);
        $result = $stmt->fetch();
        return $result;
    }


    protected function db_ticket_status_name_by_id($status_id)

    {
        $sql = "SELECT ticket_status_name
                FROM ticket_status_types
                WHERE ticket_status_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$status_id]);
        $result = $stmt->fetch();
        return $result;
    }

    protected function db_add_ticket_comment($user_id, $ticket_id, $message)
    {
        $sql = "INSERT 
                INTO ticket_comments (commenter_user_id, ticket_id, message)
                VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $ticket_id, $message]);
    }

    protected function db_create_ticket($data)
    {
        $sql = "INSERT 
                INTO tickets (title, project, developer_assigned, priority, status, type, description, submitter)
                VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $data['title'],
            $data['project_id'],
            $data['developer_assigned'],
            $data['priority_id'],
            $data['status_id'],
            $data['type_id'],
            $data['description'],
            $data['submitter']
        ]);
    }

    protected function db_create_project($data)
    {
        $sql = "INSERT 
                INTO projects (project_name, project_description, created_by)
                VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            trim($data['title']),
            trim($data['description']),
            $data['created_by']
        ]);
    }

    protected function db_assign_to_project($user_id, $project_id)
    {
        $sql = "INSERT 
                INTO project_enrollments (user_id, project_id)
                VALUES (?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $project_id]);
    }

    protected function db_unassign_from_project($user_id, $project_id)
    {
        $sql = "DELETE  
                FROM project_enrollments 
                WHERE user_id = ? AND project_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $project_id]);
    }

    protected function db_check_project_enrollment($project_id, $user_id)
    {
        $sql = "SELECT * 
                FROM project_enrollments 
                WHERE project_id = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id, $user_id]);
        $result = $stmt->fetchAll();
        return $result;
    }
}


/*
A 'statement' is any command that database understands
A 'query' is a select statement

I use prepared statements whenever user tries to change or insert or delete something on db

fetch returns 1 record as a single dimensional array
fetchAll returns all records as a multi dimensional array 

Closing the db-connection manually does not seem necessary in PHP. From the official docs: 
"Upon successful connection to the database, an instance of the PDO class is returned
 to your script. The connection remains active for the lifetime of that PDO object.
  To close the connection, you need to destroy the object by ensuring that all remaining 
  references to it are deleted--you do this by assigning NULL to the variable that
  holds the object.
  If you don't do this explicitly, PHP will automatically close the connection when your script ends.
*/