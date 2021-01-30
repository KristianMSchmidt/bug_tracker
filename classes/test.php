<?php


class Dbh

{
    private $host = "localhost";
    private $user = "kimarokko";
    private $pwd = "stjerne";
    private $dbName = "bugtracker";
    private $charset = 'utf8mb4';


    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=' .  $this->charset;

        // Create PDO ('PHD Data Object')
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


$dbh = new Dbh();



class Model extends Dbh
{

    public   function db_get_users()
    {
        $sql  = "SELECT * 
                 FROM users JOIN user_roles
                 ON users.role_id = user_roles.role_id
                 ORDER by users.full_name";
        $stmt = $this->connect()->query($sql); //stmt is a "PDO Stamement Object"
        $results = $stmt->fetchAll();

        return $results;
    }
}
$m = new Model();
$users = $m->db_get_users();
print_r($users);

?>