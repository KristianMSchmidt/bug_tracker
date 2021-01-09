<?php
echo "<script>console.log('HEJ')</script>";
$sql =
    "SELECT 
    projects.project_id,
    projects.project_name,
    projects.project_description
    FROM projects";

/* Add conditions to sql depending on user type
   Administrators should see all projects in the database
   Project Managers, Developers and Submitters should only see 
   the projects they are assigned to.
*/

if ($_SESSION['role_name'] != 'Admin') :
    $sql .= " WHERE projects.project_id IN 
              (SELECT project_id FROM project_enrollments WHERE user_id = {$_SESSION['user_id']})";
endif;

$sql .= " ORDER BY projects.created_at DESC";

// make query and get result
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo 'query error: ' . mysqli_error($conn);
    exit();
}

// fetch the resulting rows as an associative array
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory and close connection
mysqli_free_result($result);
mysqli_close($conn);
