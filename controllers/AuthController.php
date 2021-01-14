<?php

namespace app\controllers;

use app\system\Controller;
use app\system\Request;
use app\models\User;
use app\system\App;
use app\models\LoginForm;
use app\system\middlewares\AuthMiddleware;
use app\system\Response;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {

        $errors = [];
        $loginForm = new LoginForm;
        if($request->post()){

            $loginForm->data($request->body());
            if($loginForm->validate() && $loginForm->login()){

                $response->redirect('/');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('auth/login', [
            'model' => $loginForm
        ]);

    }

    public function register(Request $request)
    {

        $errors = [];

        $user = new User();
        
        if ($request->post()) {

            $user->data($request->body());

            if($user->validate() && $user->save()){

                App::$app->session->setFlash('success', 'Thank you for registration');
                App::$app->response->redirect('/');
            
            }


        }

        $this->setLayout('auth');

        return $this->render('auth/register', [
            'model' => $user
        ]);

    }

    public function logout(Request $request, Response $response)
    {
        App::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        return $this->render('account/profile');
    }

}
