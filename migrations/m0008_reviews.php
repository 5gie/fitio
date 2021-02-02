<?php

use app\system\App;

class m0008_reviews
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            profile_id INT NOT NULL,
            content TEXT NOT NULL,
            rating TINYINT NOT NULL,
            status TINYINT NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (user_id),
            INDEX (profile_id),
            FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (profile_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);
    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE reviews";
        $db->pdo->exec($sql);
    }
}
