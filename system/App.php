<?php

namespace app\system;
use app\config\ConfigRoutes;

class App extends Configroutes
{
    
    public static string $ROOT_DIR;
    public static string $ADMIN_DIR;
    
    public static App $app;
    public Database $db;

    public function __construct($root, array $config, $run = false)
    {

        self::$ROOT_DIR = $root;
        self::$app = $this;
        $this->db = new Database($config['db']);
        self::$ADMIN_DIR = dirname(__DIR__).'/admin';
        parent::__construct(strpos($_SERVER['REQUEST_URI'], $_ENV['ADMIN_ROUTE']) === false ? false : true);

    }

}
