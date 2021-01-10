<?php

/*
    Database handler. Takes care of database connection. 
    TODO: Read up on database error handling here: 
    https://phpdelusions.net/pdo

*/

class Dbh

{
    private $host = "localhost";
    private $user = "kimarokko";
    private $pwd = "stjerne";
    private $dbName = "test";
    private $charset = 'utf8mb4';


    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=' .  $this->charset;

        // Create PDO ('PHDP Data Object')
        $pdo = new PDO($dsn, $this->user, $this->pwd);

        // Pull out data as associative array (optional)
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
