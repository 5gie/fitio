<?php

namespace app\controllers;

use app\models\Approvals;
use app\models\User;
use app\models\UserApprovals;
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

                if($uploader->addUserImage(dirname(__DIR__) . '/images/user', 'image')){

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

    public function userPassword()
    {

        $user = new User;

        $getUser = User::findOne(['id' => $this->session->get('user')]);

        if ($this->request->post()) {

            if($getUser) $user->data($getUser);
            
            $user->data($this->request->body());

            if($user->validate() && $user->update(['id' => $user->id])){

                $this->session->setFlash('success', 'Zaktualizowano pomyślnie');

            } else {

                $this->session->setFlash('danger', $user->getFirstError());

            }

        }

        return $this->render('account/password', [
            'model' => $user
        ]);

    }

    public function approvals()
    {

        $approvals = Approvals::findAll([], ['id' => 'DESC']);

        $userApprovals = UserApprovals::findAll(['user_id' => $this->session->get('user')]);

        return $this->render('account/password', [
            'approvals' => $approvals,
            'userApprovals' => $userApprovals
        ]);

    }

}