<?php

namespace app\controllers;

use app\system\Controller;
use app\system\middlewares\AuthMiddleware;
use Exception;

class AccountController extends Controller
{

    public function __construct()
    {

        parent::__construct();

        $middleware = new AuthMiddleware($this->session);

        try{
             
            $middleware->execute();

        } catch(Exception $e){

            $this->response->setStatusCode($e->getCode());

            $this->session->setFlash('danger', $e->getMessage());

            $this->response->redirect('/logowanie');    

            exit;

        }
        
    }

    public function profile()
    {

        return $this->render('account/profile');

    }

}