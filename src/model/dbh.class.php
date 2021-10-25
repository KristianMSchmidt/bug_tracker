<?php

class Dbh
{
    /*
        Database handler. Takes care of database connection. 
    */

  
    // The MySQL service named in the docker-compose.yml.
    private $host = 'db';

    // Database username
    private $user = 'root';

    // database user password
    private $pwd = 'MYSQL_ROOT_PASSWORD';

    // database name
    private $dbName = 'bug_tracker';

    private $charset = 'utf8mb4';

    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=' .  $this->charset;

        // Create PDO ('Php Data Object'). 
        // Try->catch is important here, as password might otherwise get shown to users.
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
