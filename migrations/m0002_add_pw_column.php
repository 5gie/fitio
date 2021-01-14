<?php

use app\system\App;

class m0002_add_pw_column
{
    public function up()
    {
        $db = App::$app->db;
        $query = "ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "ALTER TABLE users DROP COLUMN password";
        $db->pdo->exec($sql);
    }
}
