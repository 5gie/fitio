<?php

namespace app\config;

use Bramus\Router\Router;

class ConfigRoutes
{
    public function __construct()
    {
        $router = new Router;

        $router->setNamespace('app\controllers');

        $router->get('/', 'SiteController@home');
        $router->get('/login', 'AuthController@login');
        $router->post('/login', 'AuthController@login');
        $router->get('/rejestracja', 'AuthController@register');
        $router->post('/rejestracja', 'AuthController@register');
        
        // $router->get('/contact', 'SiteController@contact');
        // $router->post('/contact', 'SiteController@contact');
        // $router->post('/login', 'AuthController@login');
        // $router->get('/register', 'AuthController@register');
        // $router->get('/logout', 'AuthController@logout');

        return $router->run();
    }
}
