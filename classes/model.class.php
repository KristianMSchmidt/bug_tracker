<?php
class Model extends Dbh
{

    protected function fetch_tickets_by_user($user_id, $role_name)
    {
        $sql =
            "SELECT 
           tickets.title,
           tickets.created_at,
           tickets.developer_assigned,
           tickets.submitter,
           projects.project_name,
           ticket_priorities.ticket_priority_name,
           ticket_status_types.ticket_status_name,
           ticket_types.ticket_type_name,
           s.username AS submitter_name,  /* alias necessary */
           d.username AS developer_name  /* alias necessary */
           FROM tickets 
           JOIN users s ON tickets.submitter = s.user_id
           JOIN users d ON tickets.developer_assigned = d.user_id
           JOIN projects ON tickets.project = projects.project_id
           JOIN ticket_status_types ON tickets.type = ticket_status_types.ticket_status_id
           JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id
           JOIN ticket_types ON tickets.type =ticket_types.ticket_type_id";

        // add conditions to sql depending on user type
        if ($role_name == 'Project Manager') :
            $sql .= " WHERE tickets.project IN 
              (SELECT project_id FROM project_enrollments WHERE user_id = ?";

        elseif ($role_name == 'Developer') :
            $sql .= " WHERE tickets.developer_assigned = ?";

        elseif ($role_name == 'Submitter') :
            $sql .= " WHERE tickets.submitter = ?";
        endif;

        // latest project at top
        $sql .= " ORDER BY tickets.created_at DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $results = $stmt->fetchAll();
        return $results;
    }
}
