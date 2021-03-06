<?php

use app\system\App;

class m0001_user
{
    public function up()
    {
        $db = App::$app->db;
        $query = "CREATE TABLE user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(512) NOT NULL,
            ckey VARCHAR(255) NULL,
            type TINYINT NOT NULL,
            status TINYINT NOT NULL,
            reset TINYINT NOT NULL,
            banned TINYINT NOT NULL,
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