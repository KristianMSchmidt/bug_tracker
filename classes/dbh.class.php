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
        // The try->catch is important here, as password might otherwise get shown
        try {
            $pdo = new PDO($dsn, $this->user, $this->pwd);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        // Pull out data as associative array (optional)
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Show errors
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        return $pdo;
    }
}
