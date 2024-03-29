<?php

class Dbh
{
    /*
        Database handler. Takes care of database connection. 
    */
  
    private $charset = 'utf8mb4';

    protected function connect()
    {
        $dsn = 'mysql:host=' . $_ENV['MYSQL_DATABASE_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'] . ';charset=' .  $this->charset;

        // Create PDO ('Php Data Object'). 
        // Try->catch is important here, as password might otherwise get shown to users.
        try {
            $pdo = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
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
