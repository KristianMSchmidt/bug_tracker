<?php
include_once('Dbh.class.php');

class CreateSessionsTable extends Dbh
{
    public function up()
    {
        $sql =
            "CREATE TABLE sessions(
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            session_id_php VARCHAR(50),
            FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE
        )";
        $this->connect()->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS sessions";
        $this->connect()->query($sql);
    }
}
