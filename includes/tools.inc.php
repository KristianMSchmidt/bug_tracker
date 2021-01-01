
<?php
/* Im not sure if these lookup tables are smart. I could do clever join queries instead 
I hvert fald burde jeg slå disse ting op i databasen i stedet for at hardcode dem. Så bliver det jo
opdateret, når databasen bliver opdateret
*/


/* bør erstattes af simpel select * from user_roles */
$role_str = array(
    1 => 'Admin',
    2 => 'Project Manager',
    3 => 'Developer',
    4 => 'Submitter',
    null => 'Null'
);
/* bør erstattes af simpel select * from ticket_priorities */
$priority_str = array(
    5 => 'Low',
    6 => 'Medium',
    7 => 'High',
    8 => 'Urgent',
    null => 'Null'
);

$ticket_status_str = array(
    1 => 'Open',
    2 => 'Closed',
    3 => 'In Progress',
    4 => 'More Info Needed',
    null => 'Null'
);

$ticket_type_str = array(
    1 => 'Feature Request',
    2 => 'Bugs/Errors',
    3 => 'Other',
    null => 'Null'

);

// find username and email of the person assigned to the project
function get_username($id)
{
    //to do: instead of making 1 query for each user id, it would be
    //better to query all id's and usernames, and then convert into array with id's as key and usernames as values
    if (!isset($id)) {
        return;
    }

    require "db_connect.inc.php";

    $sql = "SELECT username FROM users WHERE user_id = $id";

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an associative array
    $user = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];

    $username = $user['username'];

    return $username;
}
