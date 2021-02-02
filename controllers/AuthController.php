<?php

namespace app\controllers;

use app\models\Approvals;
use app\system\Controller;
use app\models\User;
use app\models\Login;
use app\models\UserApprovals;

class AuthController extends Controller
{

    public function __construct() 
    {
        $this->setLayout('auth');
        
        parent::__construct();

    }

    public function login()
    {

        $login = new Login;

        if($this->request->post()){

            $login->data($this->request->body());
            if($login->validate() && $login->login()){

                $this->session->set('user', $login->id);

                $this->response->redirect('/konto');

                return;

            } else {

                $this->session->setFlash('danger', $login->getFirstError());

            }
        }

        return $this->render('auth/login', [
            'model' => $login
        ]);

    }

    public function logout()
    {

        $this->session->remove('user');

        $this->response->redirect('/');

        $this->session->setFlash('info', 'Wylogowano pomyślnie');

        return;

    }

    public function register()
    {

        $user = new User;

        $user->registerApprovals = Approvals::findAll([], ['id' => 'DESC']);

        if ($this->request->post()) {

            $user->data($this->request->body());

            if($user->validate() && $user->validateEmail() && $user->save()){

                $userApprovals = new UserApprovals;
                $userApprovals->user_id = $user->id;
                $userApprovals->data($this->request->body());
                if(!$userApprovals->save()) error_log('Błąd przy dodawaniu user approvals');

                $this->session->setFlash('success', 'Na podany adres e-mail została wysłana wiadomośc z potwierdzeniem akceptacji konta.');

                $this->response->redirect('/');

                return;
            
            } else {

                $this->session->setFlash('danger', $user->getFirstError());

            }

        }

        return $this->render('auth/register', [
            'model' => $user,
        ]);

    }

}
