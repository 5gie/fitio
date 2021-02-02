<?php

use app\system\App;

class m0005_conversation
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE conversation (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender INT NOT NULL,
            recipient INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (sender),
            INDEX (recipient),
            FOREIGN KEY (sender) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (recipient) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE conversation";
        $db->pdo->exec($sql);
    }
}
