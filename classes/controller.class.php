<?php
class Controller extends Model
{
    public function get_tickets_by_user($user_id, $role_name)
    {
        $tickets = $this->fetch_tickets_by_user($user_id, $role_name);
        return $tickets;
    }

    public function count_tickets_in_progress($user_id, $role_name)
    {
        $tickets = $this->get_tickets_by_user($user_id, $role_name);
        $in_progress = 0;
        foreach ($tickets as $key => $value) {
            if ($value['ticket_status_name'] == 'In Progress'){
                $in_progress
            };
        }
    }
}
