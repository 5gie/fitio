<?php

namespace admin\config;

use Bramus\Router\Router;

class AdminRoutes
{
    public function __construct()
    {
        $router = new Router;

        $router->setNamespace('admin\controllers');

        $router->setBasePath('/admin');

        $router->get('/', 'DashboardController@dashboard');

        return $router->run();
    }
}
