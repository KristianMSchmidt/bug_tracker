<?php
function check_project_permission($contr, $user_id, $project_id)
{
    $users_projects = $contr->get_projects_by_user($user_id, $_SESSION['role_name']);
    foreach ($users_projects as $user_project) {
        if ($user_project['project_id'] == $project_id) {
            return True;
        }
    }
    return False;
}
