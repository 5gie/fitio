<?php

namespace app\system;
use app\config\ConfigRoutes;

class App 
{
    
    public static string $ROOT_DIR;

    public static App $app;
    public Database $db;

    public function __construct($root, array $config, $run = false)
    {

        self::$ROOT_DIR = $root;
        self::$app = $this;
        $this->db = new Database($config['db']);

        if ($run) new ConfigRoutes;

    }


    // public static function isGuest(): bool
    // {
    //     return !self::$app->user;
    // }


}