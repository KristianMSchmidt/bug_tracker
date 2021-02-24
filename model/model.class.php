<?php
require_once('dbh.class.php');

class Model extends Dbh
{
    /*

        This is the only class that direcly interacts (queries or modifies) the database. 

    */

    protected function db_get_all_project_ids()
    {
        $sql = "SELECT projects.id as project_id FROM projects";
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    protected function db_get_user_project_ids($user_id)
    {
        $sql = "SELECT tickets.project_id as project_id
                    FROM tickets 
                    WHERE (tickets.developer_assigned_id = {$user_id} 
                    OR tickets.submitter_id = {$user_id})
                UNION 
                SELECT projects.id as project_id
                    FROM projects 
                    WHERE projects.id IN 
                        (SELECT project_enrollments.project_id 
                        FROM project_enrollments 
                        WHERE project_enrollments.user_id = {$user_id})";
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    protected function db_get_projects_details_from_project_id_array($project_id_array, $user_id, $order_by, $order_direction)
    {
        // sql uses the syntax:  WHERE projects.id IN ('1', '2', '3', '4')
        $sql = 'SELECT 
                    projects.id as project_id,
                    projects.project_name,
                    projects.project_description,
                    projects.created_at,
                    projects.updated_at,
                    project_enrollments.enrollment_start,
                    users.full_name as created_by
                FROM projects 
                JOIN users ON projects.created_by = users.id
                LEFT JOIN project_enrollments ON project_enrollments.user_id=' . "{$user_id}" . ' AND project_enrollments.project_id = projects.id
                WHERE projects.id IN (' . implode(',', $project_id_array) . ')
                ORDER BY ' . "{$order_by}" . " {$order_direction}";
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    protected function db_get_user_by_email($email)
    {
        $sql = "SELECT 
                    users.password,
                    users.full_name,
                    users.email,
                    users.id as user_id,
                    user_roles.role_name
                FROM users JOIN user_roles
                ON users.role_id = user_roles.id 
                WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
        $results = $stmt->fetch();
        return $results;
    }

    protected function db_get_user_by_name($full_name)
    {
        $sql = "SELECT users.id
                FROM users
                WHERE users.full_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$full_name]);
        $results = $stmt->fetch();
        return $results;
    }

    protected function db_get_project_enrollments_by_user_id($user_id)
    {
        $sql = "SELECT
                    project_enrollments.project_id,
                    project_enrollments.enrollment_start 
                FROM project_enrollments 
                WHERE project_enrollments.user_id = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_most_busy_users()
    {
        $sql = "SELECT 
                    COUNT(tickets.id) as count, users.full_name
                FROM tickets 
                LEFT JOIN users ON tickets.developer_assigned_id = users.id    
                WHERE tickets.status_id = 3 
                GROUP BY tickets.developer_assigned_id
                ORDER BY count(tickets.id) ASC LIMIT 5";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_create_user($full_name, $pwd, $email, $role_id)
    {

        $sql = "INSERT INTO 
                users(full_name, password, email, role_id)
                VALUES(?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$full_name, $pwd, $email, $role_id]);
    }

    protected function db_check_project_enrollment($user_id, $project_id)
    {
        $sql = "SELECT user_id, project_id 
                FROM project_enrollments 
                WHERE project_enrollments.project_id = $project_id
                AND project_enrollments.user_id = $user_id";
        $stmt = $this->connect()->query($sql);
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_user_tickets_details($user_id, $role_name, $order_by, $order_direction)
    {
        $sql = "SELECT 
                    tickets.title,
                    tickets.id as ticket_id,
                    tickets.created_at,
                    tickets.updated_at,
                    tickets.developer_assigned_id,
                    tickets.submitter_id,
                    tickets.project_id,
                    projects.project_name,
                    ticket_priorities.priority_name as ticket_priority_name,
                    ticket_status_types.status_name as ticket_status_name,
                    ticket_types.type_name as ticket_type_name,
                    s.full_name AS submitter_name,  /* alias necessary */
                    d.full_name AS developer_name  /* alias necessary */
                FROM tickets 
                LEFT JOIN users s ON tickets.submitter_id = s.id
                LEFT JOIN users d ON tickets.developer_assigned_id = d.id
                JOIN projects ON tickets.project_id = projects.id
                JOIN ticket_status_types ON tickets.status_id = ticket_status_types.id
                JOIN ticket_priorities ON tickets.priority_id = ticket_priorities.id
                JOIN ticket_types ON tickets.type_id =ticket_types.id";

        // Admins should see all tickets
        // Project Managers, Developers and Submitters should see all tickets where they are submitter or developer assigned
        // Project Managers should in addition see all ticket to all the projects are part of. 

        if ($role_name !== 'Admin') :
            $sql .= " WHERE tickets.submitter_id = {$user_id} OR tickets.developer_assigned_id = {$user_id}";
        endif;

        if ($role_name == 'Project Manager') :
            $sql .= " OR (tickets.project_id IN 
              (SELECT project_id FROM project_enrollments WHERE project_enrollments.user_id = {$user_id}))";
        endif;

        $sql .= " ORDER BY {$order_by} {$order_direction}";

        $stmt = $this->connect()->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll();

        return $results;
    }

    protected function db_get_ticket_priority_count()
    {
        $sql = "SELECT 
                    COUNT(tickets.id) AS count, 
                    ticket_priorities.priority_name as ticket_priority_name
                FROM tickets RIGHT JOIN ticket_priorities ON tickets.priority_id = ticket_priorities.id 
                GROUP BY ticket_priorities.id 
                ORDER BY ticket_priorities.id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_ticket_status_count()
    {

        $sql = "SELECT 
                    COUNT(tickets.id) AS count, 
                    ticket_status_types.status_name as ticket_status_name
                FROM tickets RIGHT JOIN ticket_status_types 
                ON tickets.status_id = ticket_status_types.id
                GROUP BY ticket_status_types.id 
                ORDER BY ticket_status_types.id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_tickets_type_count()
    {
        $sql = "SELECT 
                    COUNT(tickets.id),
                    ticket_types.type_name as ticket_type_name 
                FROM tickets RIGHT JOIN ticket_types ON tickets.type_id = ticket_types.id
                GROUP BY ticket_types.id ORDER BY ticket_types.id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function db_get_all_user_ids()
    {
        $sql = "SELECT users.id as user_id FROM users";
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    protected function db_get_users_details_from_user_id_array($user_id_array, $order_by, $order_direction)
    {
        $sql = 'SELECT 
                    users.id as user_id,
                    users.full_name,
                    users.email, 
                    users.updated_at, 
                    users.created_at,
                    user_roles.role_name,
                    ub.full_name AS updated_by 
                FROM users JOIN user_roles ON users.role_id = user_roles.id
                LEFT JOIN users ub ON users.updated_by = ub.id 
                WHERE users.id IN (' . implode(',', $user_id_array) . ')
                ORDER BY ' . "{$order_by}" . " {$order_direction}";
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    protected function db_get_project_users($project_id, $role_id)
    {
        $sql =
            "SELECT 
                users.full_name,
                users.email,
                user_roles.role_name,
                users.id as user_id,
                project_enrollments.enrollment_start
            FROM users 
            JOIN project_enrollments ON users.id = project_enrollments.user_id
            JOIN user_roles ON user_roles.id = users.role_id
            WHERE project_enrollments.project_id = ?";

        if ($role_id !== "all_roles") {
            $sql .= " AND users.role_id = ? ORDER BY users.full_name";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$project_id, $role_id]);
        } else {
            $sql .= " ORDER BY users.full_name";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$project_id]);
        }
        $users = $stmt->fetchAll();
        return $users;
    }

    protected function db_get_users_not_enrolled_in_project($project_id)
    {
        $sql =
            "SELECT 
                users.full_name,
                users.id as user_id,
                user_roles.role_name
            FROM users 
            JOIN user_roles ON user_roles.id = users.role_id
            WHERE users.id NOT IN 
                (SELECT user_id FROM project_enrollments WHERE project_enrollments.project_id=?)
            ORDER BY users.full_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $users = $stmt->fetchAll();
        return $users;
    }

    protected function db_get_notifications_by_user_id($user_id)
    {
        $sql = "SELECT 
                    notifications.unseen,
                    notifications.created_at, 
                    notifications.created_by as creator_id,
                    notifications.user_id, 
                    notifications.info_id,
                    notification_types.id as type,
                    notification_types.submitter_action as submitter_action, 
                    users.full_name as creator_name
                FROM notifications
                JOIN notification_types ON notifications.notification_type_id = notification_types.id
                LEFT JOIN users ON notifications.created_by = users.id
                WHERE notifications.user_id = ?
                ORDER BY notifications.id DESC";

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

    protected function db_update_role($role_id, $updater, $user_id)
    {
        $sql = "UPDATE users SET
                    role_id = ?,
                    updated_by = ? 
                WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role_id, $updater, $user_id]);
    }

    protected function db_check_project_name_unique($project_name, $project_id)
    {
        $sql = "SELECT projects.id 
                FROM projects 
                WHERE project_name = ? AND projects.id <> ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_name, $project_id]);
        $result = $stmt->fetch();
        return $result;
    }

    protected function db_check_ticket_title_unique($ticket_title, $ticket_id, $project_id)
    {
        $sql = "SELECT tickets.id 
                FROM tickets 
                WHERE tickets.title = ? AND tickets.id <> ? AND tickets.project_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_title, $ticket_id, $project_id]);
        $project = $stmt->fetch();
        return $project;
    }

    protected function db_get_tickets_by_project($project_id)
    // all tickets to given project
    // TODO: merge this function with db_get_tickets_by_id
    {
        $sql = "SELECT
            tickets.id,
            tickets.title,
            tickets.created_at,
            tickets.developer_assigned_id,
            tickets.project_id,
            tickets.submitter_id,
            ticket_priorities.priority_name as ticket_priority_name,
            ticket_status_types.status_name as ticket_status_name,
            ticket_types.type_name as ticket_type_name,
            s.full_name AS submitter_name,  /* alias necessary */
            d.full_name AS developer_name   /* alias necessary */
        FROM tickets 
        LEFT JOIN users s ON tickets.submitter_id = s.id
        LEFT JOIN users d ON tickets.developer_assigned_id = d.id
        JOIN projects ON tickets.project_id = projects.id
        JOIN ticket_status_types ON tickets.status_id = ticket_status_types.id
        JOIN ticket_priorities ON tickets.priority_id = ticket_priorities.id
        JOIN ticket_types ON tickets.type_id =ticket_types.id
        WHERE tickets.project_id = ?
        ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $tickets = $stmt->fetchAll();
        return $tickets;
    }

    protected function db_get_ticket_by_id($ticket_id)
    {
        $sql = "SELECT
            tickets.id as ticket_id,
            tickets.type_id,
            tickets.status_id,
            tickets.priority_id,
            tickets.developer_assigned_id,
            tickets.submitter_id,
            tickets.project_id,
            tickets.title,
            tickets.description,
            tickets.created_at,
            tickets.updated_at,
            ticket_priorities.priority_name as ticket_priority_name,
            ticket_status_types.status_name as ticket_status_name,
            ticket_types.type_name as ticket_type_name,
            projects.project_name,
            s.full_name AS submitter_name,  /* alias necessary */
            d.full_name AS developer_name   /* alias necessary */
        FROM tickets 
        /* left join er vigtig her, da der stadig skal findes resultater frem fra tickets,
         selvom f.eks. submitteren i mellemtiden er blevet slettet        
        */
        LEFT JOIN users s ON tickets.submitter_id = s.id
        LEFT JOIN users d ON tickets.developer_assigned_id = d.id
        JOIN projects ON tickets.project_id = projects.id
        JOIN ticket_status_types ON tickets.status_id = ticket_status_types.id
        JOIN ticket_priorities ON tickets.priority_id = ticket_priorities.id
        JOIN ticket_types ON tickets.type_id =ticket_types.id
        WHERE tickets.id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id]);
        $tickets = $stmt->fetch();
        return $tickets;
    }


    protected function db_create_notification($notification_type_id, $info_id, $user_id, $created_by)
    {
        $sql = "INSERT INTO notifications(notification_type_id, info_id, user_id, unseen, created_by)
                 VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$notification_type_id, $info_id, $user_id, 1, $created_by]);
    }

    protected function db_add_to_ticket_events($ticket_id, $event_type_id, $old_value, $new_value)
    {
        $sql = "INSERT INTO ticket_events(ticket_id, type_id, old_value, new_value) VALUES (?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id, $event_type_id, $old_value, $new_value]);
    }

    protected function db_get_priorities()
    {
        $sql = "SELECT 
                    ticket_priorities.id, 
                    ticket_priorities.priority_name as ticket_priority_name
                FROM ticket_priorities";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $priorities = $stmt->fetchAll();
        return $priorities;
    }

    protected function db_get_ticket_types()
    {
        $sql = "SELECT 
                    ticket_types.id as ticket_type_id,
                    ticket_types.type_name as ticket_type_name
                FROM ticket_types";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $types = $stmt->fetchAll();
        return $types;
    }

    protected function db_get_ticket_status_types()
    {
        $sql = "SELECT ticket_status_types.id as ticket_status_id,
                       ticket_status_types.status_name as ticket_status_name 
                FROM ticket_status_types";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $status_types = $stmt->fetchAll();
        return $status_types;
    }

    protected function db_update_ticket($data)
    {
        $sql = "UPDATE tickets 
                SET 
                    title = ?,
                    developer_assigned_id = ?,
                    priority_id=?,
                    status_id = ?,
                    type_id = ?,
                    description = ?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE tickets.id = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            trim($data['title']),
            $data['developer_assigned_id'],
            $data['priority_id'],
            $data['status_id'],
            $data['type_id'],
            trim($data['description']),
            $data['ticket_id']
        ]);
    }

    protected function db_update_project($project_title, $project_description, $project_id)
    {

        $sql = "UPDATE projects 
                SET 
                    project_name = ?,
                    project_description = ?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE projects.id = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([trim($project_title), trim($project_description), $project_id]);
    }

    protected function db_get_role_name_by_role_id($role_id)
    {
        $sql = "SELECT role_name 
                FROM user_roles
                WHERE user_roles.id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role_id]);
        $role_name = $stmt->fetch()['role_name'];
        return $role_name;
    }

    protected function db_get_ticket_events($ticket_id)
    {
        $sql = "SELECT 
                    ticket_events.old_value, 
                    ticket_events.new_value, 
                    ticket_events.created_at,
                    ticket_event_types.ticket_event_type 
                FROM ticket_events LEFT JOIN ticket_event_types ON ticket_events.type_id = ticket_event_types.id
                WHERE ticket_events.ticket_id = ?
                ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id]);
        $ticket_events = $stmt->fetchAll();
        return $ticket_events;
    }

    protected function db_get_ticket_comments($ticket_id)
    {
        $sql = "SELECT 
                    ticket_comments.comment, 
                    ticket_comments.created_at,
                    users.full_name as commenter
                FROM ticket_comments
                LEFT JOIN users on ticket_comments.commenter_user_id = users.id
                WHERE ticket_comments.ticket_id = ?
                ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_id]);
        $comments = $stmt->fetchAll();
        return $comments;
    }


    protected function db_get_project_name_by_id($project_id)
    {
        $sql = "SELECT project_name 
                FROM projects 
                WHERE projects.id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$project_id]);
        $project_name = $stmt->fetch()['project_name'];
        return $project_name;
    }

    protected function db_get_priority_name_by_id($priority_id)
    {
        $sql = "SELECT priority_name as ticket_priority_name
                FROM ticket_priorities
                WHERE ticket_priorities.id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$priority_id]);
        $result = $stmt->fetch();
        return $result;
    }

    protected function db_ticket_type_name_by_id($type_id)
    {
        $sql = "SELECT type_name as ticket_type_name
                FROM ticket_types
                WHERE ticket_types.id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$type_id]);
        $result = $stmt->fetch();
        return $result;
    }


    protected function db_ticket_status_name_by_id($status_id)
    {
        $sql = "SELECT 
                status_name as ticket_status_name
                FROM ticket_status_types
                WHERE ticket_status_types.id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$status_id]);
        $result = $stmt->fetch();
        return $result;
    }

    protected function db_add_ticket_comment($user_id, $ticket_id, $comment)
    {
        $sql = "INSERT 
                INTO ticket_comments (commenter_user_id, ticket_id, comment)
                VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $ticket_id, $comment]);
    }

    protected function db_create_ticket($data)
    {
        $sql = "INSERT 
                INTO tickets (title, project_id, developer_assigned_id, priority_id, status_id, type_id, description, submitter_id)
                VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            trim($data['title']),
            trim($data['project_id']),
            trim($data['developer_assigned_id']),
            trim($data['priority_id']),
            trim($data['status_id']),
            trim($data['type_id']),
            trim($data['description']),
            trim($data['submitter_id'])
        ]);
    }

    protected function db_create_project($data)
    {
        $sql = "INSERT 
                INTO projects (project_name, project_description, created_by)
                VALUES (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            trim($data['project_name']),
            trim($data['project_description']),
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

    protected function db_get_ticket_id_by_title_and_project($ticket_title, $project_id)
    {

        $sql = "SELECT tickets.id FROM tickets WHERE tickets.title = ? AND tickets.project_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ticket_title, $project_id]);
        $result = $stmt->fetchAll();
        return $result;
    }
}

/* Notes to self: 

    For security reasons, I use prepared statements whenever user tries to change or insert or delete something on db. 

    Closing the db-connection manually does not seem necessary in PHP. From the official docs: 

        "Upon successful connection to the database, an instance of the PDO class is returned
        to your script. The connection remains active for the lifetime of that PDO object.
        To close the connection, you need to destroy the object by ensuring that all remaining 
        references to it are deleted--you do this by assigning NULL to the variable that
        holds the object.
        If you don't do this explicitly, PHP will automatically close the connection when your script ends."
*/