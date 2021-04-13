<?php

namespace app\config;

use Bramus\Router\Router;

class ConfigRoutes
{
    public function __construct()
    {
        $router = new Router;

        $router->setNamespace('app\controllers');

        $router->get('/test', 'SiteController@fetch');
        $router->get('/', 'SiteController@home');
        $router->get('/logowanie', 'AuthController@login');
        $router->post('/logowanie', 'AuthController@login');
        $router->get('/rejestracja', 'AuthController@register');
        $router->post('/rejestracja', 'AuthController@register');
        $router->get('/aktywacja/{ckey}', 'AuthController@activate');
        $router->get('/reset', 'AuthController@reset');
        $router->post('/reset', 'AuthController@reset');
        $router->get('/haslo/{ckey}', 'AuthController@newPassword');
        $router->post('/haslo/{ckey}', 'AuthController@newPassword');
        
        $router->get('/wyloguj', 'AuthController@logout');
        
        $router->mount('/konto', function() use ($router) {

            $router->get('/', 'AccountController@account');
            $router->get('/dane', 'AccountController@userData');
            $router->post('/dane', 'AccountController@userData');
            $router->get('/haslo', 'AccountController@userPassword');
            $router->post('/haslo', 'AccountController@userPassword');
            $router->get('/zgody', 'AccountController@approvals');
            $router->post('/zgody', 'AccountController@approvals');
            $router->get('/usun', 'AccountController@userDelete');
            $router->post('/usun', 'AccountController@userDelete');
            $router->get('/opinie', 'AccountController@userReviews');
            $router->post('/opinie', 'AccountController@userReviews');

            $router->mount('/wiadomosci', function () use ($router) {

                $router->get('/', 'MessageController@listConversations');
                $router->get('/{id}', 'MessageController@conversation');
                $router->post('/{id}', 'MessageController@conversation');

            });

        });

        $router->mount('/profil/{id}', function() use ($router) {
            
            $router->before('GET|POST', '/', 'ProfileController@auth');
            $router->before('GET|POST', '/.*', 'ProfileController@auth');
            
            $router->get('/wiadomosc', 'MessageController@newConversation');
            $router->post('/wiadomosc', 'MessageController@newConversation');
            
            $router->get('/opinie', 'ProfileController@reviews');
            $router->get('/opinie/dodaj', 'ProfileController@addReview');
            $router->post('/opinie/dodaj', 'ProfileController@addReview');
            
            $router->get('/', 'ProfileController@profile');
            
        });

        $router->get('/uzytkownicy', 'UsersController@list');
        $router->get('/uzytkownicy/strona/{page}', 'UsersController@list');
   
        // $router->post('/contact', 'SiteController@contact');
        // $router->post('/login', 'AuthController@login');
        // $router->get('/register', 'AuthController@register');
        // $router->get('/logout', 'AuthController@logout');
        
        return $router->run();
    }
}
