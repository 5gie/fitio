<?php

use app\system\App;

class m0010_subpage
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE subpage (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(250) NOT NULL,
            content TEXT NULL,
            seo VARCHAR(250) NULL,
            meta_title VARCHAR(250) NULL,
            meta_desc TEXT NULL,
            meta_keywords VARCHAR(250) NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE subpage";
        $db->pdo->exec($sql);
    }
}
