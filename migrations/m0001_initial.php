<?php

use app\system\App;

class m0001_initial 
{
    public function up()
    {
        $db = App::$app->db;
        $query = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE users";
        $db->pdo->exec($sql);
    }
}