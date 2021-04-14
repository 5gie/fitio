<?php

use admin\Admin;
use app\system\App;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../config/defines.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'dbname' => $_ENV['DB_NAME'],
        'password' => $_ENV['DB_PASSWORD']
    ],
];

if(strpos($_SERVER['REQUEST_URI'], $_ENV['ADMIN_ROUTE']) === false){

    $app = new App(dirname(__DIR__), $config, true);
    
} else {
    
    $admin = new Admin(dirname(__DIR__), $config);

}


function debug($var)
{
    echo "<pre style='padding:10px;font-size:12px;background:#2D2D2D;color:#d0d0d0;'>";
    echo '<h4 style="color:#FF5A5A">DEBUG MODE:</h4>';
    if (empty($var)) {
        echo 'TABLICA / ZMIENNA PUSTA!';
    } else {
        print_r($var);
    }
    echo "</pre>";
}
