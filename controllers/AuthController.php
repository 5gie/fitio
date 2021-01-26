<?php

namespace app\controllers;

use app\system\Controller;
use app\models\User;
use app\models\Login;

class AuthController extends Controller
{

    public function __construct() 
    {
        $this->setLayout('auth');

        parent::__construct();
    }

    public function login()
    {

        $this->session->setFlash('success', 'afasdfdfsaafsdfsd');

        $this->response->redirect('/');
        

        $login = new Login;

        if($this->request->post()){

            $login->data($this->request->body());
            if($login->validate() && $login->login()){

                $this->session->setFlash('success', 'afasdfdfsaafsdfsd');

                $this->response->redirect('/');

                return;

            } else {

              
                $error = $login->getFirstError();

            }
        }

        return $this->render('auth/login', [
            'model' => $login
        ]);

    }

    public function register()
    {

        $user = new User();
        
        if ($this->request->post()) {

            $user->data($this->request->body());

            if($user->validate() && $user->save()){

                // App::$app->session->setFlash('success', 'Thank you for registration');
                // App::$app->response->redirect('/');
            
            }


        }

        return $this->render('auth/register', [
            'model' => $user
        ]);

    }

    // public function logout(Request $request, Response $response)
    // {
    //     App::$app->logout();
    //     $response->redirect('/');
    // }

    public function profile()
    {
        return $this->render('account/profile');
    }

}
