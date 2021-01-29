<?php

use app\system\App;

class m0003_approvals
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE approvals (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            required TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);

    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE approvals";
        $db->pdo->exec($sql);
    }
}
