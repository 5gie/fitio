<?php

use app\controllers\SiteController;
use app\controllers\AuthController;
use app\models\User;
use app\system\App;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

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

$app = new App(dirname(__DIR__), $config);

$app->router->get('/', 'home');
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/profile', [AuthController::class, 'profile']);


$app->run();


function debug($var)
{
    echo "<pre style='padding:10px;font-size:12px;background:#2D2D2D;color:#d0d0d0'>";
    echo '<h4 style="color:#FF5A5A">DEBUG MODE:</h4>';
    if (empty($var)) {
        echo 'TABLICA / ZMIENNA PUSTA!';
    } else {
        var_dump($var);
    }
    echo "</pre>";
}
