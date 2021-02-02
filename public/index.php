<?php
use app\models\User;
use app\system\App;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../config/defines.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]  
];

$app = new App(dirname(__DIR__), $config, true);

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
