<?php

/*
    This is the only class that is allowed to directly interact with the database. 
*/

class Users extends Dbh
{
    protected function getUsers()
    {
        $sql  = "SELECT * FROM users";
        $stmt = $this->connect()->query($sql); //stmt is a "PDO Stamement Object"
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function getUsersByRoleID($role_id)

    {
        $sql  = "SELECT * FROM users WHERE role_id = {$role_id}?";
        $stmt = $this->connect()->query($sql);
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setUser($username, $pwd, $email, $role_id)
    {

        $sql = "INSERT INTO users(username, password, email, role_id)
                VALUES(?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username, $pwd, $email, $role_id]);
    }

    public function getProjectsByUserId($user_id)
    {
        $sql = "SELECT 
                projects.project_id,
                projects.project_name,
                projects.project_description
                FROM projects
                WHERE projects.project_id IN 
                    (SELECT project_id 
                    FROM project_enrollments 
                    WHERE user_id = {$user_id})";

        $stmt = $this->connect()->query($sql);
        $results = $stmt->fetchAll();
        return $results;
    }
}

/*
A 'statement' is any command that database understands
A 'query' is a select statement

I use prepared statements whenever user tries to change or insert or delete something on db

fetch returns 1 record as a single dimensional array
fetchAll returns all records as a multi dimensional array 

Closing the db-connection manually does not seem necessary in PHP. From the official docs: 
"Upon successful connection to the database, an instance of the PDO class is returned
 to your script. The connection remains active for the lifetime of that PDO object.
  To close the connection, you need to destroy the object by ensuring that all remaining 
  references to it are deleted--you do this by assigning NULL to the variable that
  holds the object.
  If you don't do this explicitly, PHP will automatically close the connection when your script ends.
*/