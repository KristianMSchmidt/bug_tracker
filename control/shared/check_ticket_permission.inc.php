<?php
function check_ticket_permission($contr, $user_id, $ticket_id)
{
    $users_tickets = $contr->get_tickets_by_user_and_role($user_id, $_SESSION['role_name']);
    foreach ($users_tickets as $user_ticket) {
        if ($user_ticket['ticket_id'] == $ticket_id) {
            return True;
        }
    }
    return False;
}
