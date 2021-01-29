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
        $router->get('/logowanie', 'AuthController@login');
        $router->post('/logowanie', 'AuthController@login');
        $router->get('/rejestracja', 'AuthController@register');
        $router->post('/rejestracja', 'AuthController@register');
        
        $router->get('/wyloguj', 'AuthController@logout');
        
        $router->mount('/profil', function() use ($router) {

            $router->get('/', 'AccountController@profile');
            $router->get('/dane', 'AccountController@userData');
            $router->post('/dane', 'AccountController@userData');
            $router->get('/haslo', 'AccountController@userPassword');
            $router->post('/haslo', 'AccountController@userPassword');

        });
        
        // $router->post('/contact', 'SiteController@contact');
        // $router->post('/login', 'AuthController@login');
        // $router->get('/register', 'AuthController@register');
        // $router->get('/logout', 'AuthController@logout');

        return $router->run();
    }
}
