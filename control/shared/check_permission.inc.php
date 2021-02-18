<?php

function check_ticket_permission($contr, $user_id, $ticket_id)
{

    //Admins will get 'ticket permission' to all tickets.
    //Devs, Submittters and Project Managers will get permission to the tickets where they are either
    //     assigned developers or submitters
    //Project Managers will also get permission to all tickets to all the projects they are enrolled in

    // Ticket permissions are given to the exact same tickets as the ones being shown in "My Tickets"

    $users_tickets = $contr->get_tickets_by_user_and_role($user_id, $_SESSION['role_name']);

    foreach ($users_tickets as $user_ticket) {
        if ($user_ticket['ticket_id'] == $ticket_id) {
            return True;
        }
    }
    return False;
}


function check_project_permission($contr, $user_id, $project_id)
{
    //Admins will get permission to all projects
    //Other users will only get permission to the tickets they are enrolled in

    //Project permissions are given to the exact same projects as the ones being shown in "My Project"

    $users_projects = $contr->get_projects_by_user($user_id, $_SESSION['role_name']);
    foreach ($users_projects as $user_project) {
        if ($user_project['project_id'] == $project_id) {
            return True;
        }
    }
    return False;
}
