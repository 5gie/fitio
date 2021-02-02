<?php

use app\system\App;

class m0006_message
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE message (
            id INT AUTO_INCREMENT PRIMARY KEY,
            conversation_id INT NOT NULL,
            user_id INT NOT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (conversation_id),
            FOREIGN KEY (conversation_id) REFERENCES conversation(id) ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE message";
        $db->pdo->exec($sql);
    }
}
