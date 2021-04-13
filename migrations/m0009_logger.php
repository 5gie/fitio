<?php

use app\system\App;

class m0009_logger
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE logger (
            id INT AUTO_INCREMENT PRIMARY KEY,
            log TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE logger";
        $db->pdo->exec($sql);
    }
}
