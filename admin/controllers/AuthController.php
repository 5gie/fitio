<?php

namespace admin\controllers;

use app\models\Login;
use app\system\AdminController;
use app\system\form\Form;

class AuthController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {

        $this->view->setLayout('login');

        $login = new Login;

        $this->view->form = new Form;

        if($this->request->post()) {

            $login->data($this->request->body());

            if ($login->login()) {

                $this->response->redirect('/admin');
                return;

            } 

        }

        return $this->view->render('login', [
            'model' => $login
        ]);

    }

}