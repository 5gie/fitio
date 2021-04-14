<?php

namespace admin;
use admin\config\AdminRoutes;
use app\system\Database;

class Admin
{
    
    public static string $ROOT_DIR;
    public static string $ADMIN_DIR;

    public static Admin $admin;
    public Database $db;

    public function __construct($root, array $config)
    {

        self::$ROOT_DIR = $root;
        self::$ADMIN_DIR = dirname(__DIR__).'/admin';

        self::$admin = $this;
        $this->db = new Database($config['db']);
        new AdminRoutes;

    }

}