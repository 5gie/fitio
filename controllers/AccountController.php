<?php

namespace app\controllers;

use app\models\User;
use app\models\UserData;
use app\system\Controller;
use app\system\helpers\Uploader;
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

    public function userData()
    {

        $userData = new UserData;

        $userData->user_id = $this->session->get('user');

        $data = UserData::findOne(['user_id' => $userData->user_id]);

        if($data) $userData->data($data);

        if ($this->request->post()) {

            $userData->data($this->request->body());

            if($this->request->file('image')){

                $uploader = new Uploader;

                if($uploader->addUserImage($this->request->file('image'))){

                    $userData->image = $uploader->name;

                } else {

                    $this->session->setFlash('danger', $uploader->error);

                }

            }
            
            if ($userData->validate() && ($data ? $userData->update(['user_id' => $userData->user_id]) : $userData->save())) {

                $this->session->setFlash('success', 'Zaktualizowano pomyślnie');

            } else {

                $this->session->setFlash('danger', $userData->getFirstError());

            }

        }

        return $this->render('account/data',[
            'model' => $userData
        ]);

    }

}