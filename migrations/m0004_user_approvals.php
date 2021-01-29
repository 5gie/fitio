<?php

use app\system\App;

class m0004_user_approvals
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE user_approvals (
            user_id INT NOT NULL,
            approval_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (user_id),
            INDEX (approval_id),
            FOREIGN KEY (approval_id) REFERENCES approvals(id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);

    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE user_approvals";
        $db->pdo->exec($sql);
    }
}
