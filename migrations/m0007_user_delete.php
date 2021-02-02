<?php

use app\system\App;

class m0006_message
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE user_delete (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            status TEXT NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE user_delete";
        $db->pdo->exec($sql);
    }
}
