<?php
// Running this script will recreate the entire database and all the tables 
$mysql_host = "localhost";
$mysql_database = "test";
$mysql_user = "kimarokko";
$mysql_password = "stjerne";

# MySQL with PDO_MYSQL
$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
$query = file_get_contents("create_db.sql");
$stmt = $db->prepare($query);
if ($stmt->execute()) {
     echo "Success";
} else {
     echo "Fail";
}
