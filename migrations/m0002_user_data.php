<?php

use app\system\App;

class m0002_user_data
{
    public function up()
    {
        $db = App::$app->db;

        $query = "CREATE TABLE user_data (
            user_id INT UNIQUE,
            name VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            image VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($query);

        $query3 = "ALTER TABLE `user_data` ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; COMMIT;";
        $db->pdo->exec($query3);

    }

    public function down()
    {
        $db = App::$app->db;
        $sql = "DROP TABLE users_data";
        $db->pdo->exec($sql);
    }
}
