<?php

namespace app\controllers;

use app\models\User;
use app\models\UserData;
use app\system\Controller;
use app\system\helpers\Uploader;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->setLayout('profile');
        
    }

    public function auth($id)
    {
        if($this->session->get('user') == $id) $this->response->redirect('/konto');
    }

    public function profile($id)
    {
        $user = User::findOne(['id' => $id]);
        
        if($user){
            
            $user->data = UserData::findOne(['user_id' => $id]);

            if($user->data && !empty($user->data->image)) $user->data->image = '/images/user/' . $user->data->image; 

            return $this->render('profile/profile', [
                'user' => $user
            ]);


        } else {

            $this->session->setFlash('error', 'Taki użytkownik nie istnieje lub został usunięty.');

            $this->response->redirect('/');

        }

    }

    public function userData()
    {

        $userData = new UserData;

        $userData->user_id = $this->session->get('user');

        $data = UserData::findOne(['user_id' => $userData->user_id]);

        if ($data) $userData->data($data);

        if ($this->request->post()) {

            $userData->data($this->request->body());

            if ($this->request->file('image')) {

                $uploader = new Uploader;

                if ($uploader->addUserImage(dirname(__DIR__) . '/images/user', 'image')) {

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

        return $this->render('account/data', [
            'model' => $userData
        ]);

    }

    public function userImage($image): void
    {
        if(!empty($image)) echo "<img src='$image'/>";
    }

}
