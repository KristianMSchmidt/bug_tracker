<?php
class Tickets extends Dbh
{

    public function get_ticket_priority_count()
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

    public function get_ticket_status_count()
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

    public function get_tickets_type_count()
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
}
