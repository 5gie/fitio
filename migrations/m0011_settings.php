<?php

use app\system\App;

class m0011_settings
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE settings (
            meta_title VARCHAR(250) NULL,
            meta_desc TEXT NULL,
            meta_keywords VARCHAR(250) NULL,
            email VARCHAR(250) NOT NULL,
            phone VARCHAR(250) NULL,
            updated_at TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE settings";
        $db->pdo->exec($sql);
    }
}
