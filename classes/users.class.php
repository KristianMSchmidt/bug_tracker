<?php

//This is the model in the MCV structure. Only interacts with database. 

class Users extends Dbh
{
    protected function getUsers()   //protected, so that this can only be used by this class and its children
    // No need for using prepared statements here, as there is no user input
    {
        $sql  = "SELECT * FROM users";
        $stmt = $this->connect()->query($sql); //stmt is a "PDO Stamement Object"
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function getUsersByRoleID($role_id)
    // Note use of prepared statements (for safety).
    // Prepared statements are recommended instead of mysqli_real_escape_string
    // What prepared statements do, is the following: 
    // The database runs the prepared statements first - as code.
    // When it later receives the actual parameters, it only treats these as strings - not as code. 
    {
        $sql  = "SELECT * FROM users WHERE role_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role_id]); //stmt is a "PDO Stamement Object"
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setUser($username, $pwd, $email, $role_id)
    // Note use of prepared statements (for safety)
    {

        $sql = "INSERT INTO users(username, password, email, role_id)
                VALUES(?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username, $pwd, $email, $role_id]);
    }
}

/*
A 'statement' is any command that database understands
A 'query' is a select statement

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