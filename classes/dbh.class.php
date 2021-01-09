<?php
/*
    Database handler
    This class should only takes care of database connections. 
*/

class Dbh

{
    private $host = "localhost";
    private $user = "kimarokko";
    private $pwd = "stjerne";
    private $dbName = "test";

    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;

        // Create PDO ('PHDP Data Object')
        $pdo = new PDO($dsn, $this->user, $this->pwd);

        // Pull out data as associative array (optional)
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
