<?php

namespace app\controllers;

use app\models\Approvals;
use app\models\Review;
use app\models\User;
use app\models\UserApprovals;
use app\models\UserData;
use app\models\UserDelete;
use app\system\Controller;
use app\system\helpers\Image;
use app\system\helpers\Uploader;

class AccountController extends Controller
{

    public function __construct()
    {

        parent::__construct();

        if(!$this->checkAuth()) return;
        
    }

    public function account()
    {

        $user = User::findOne(['id' => $this->session->get('user')]);
        
        $user->data = UserData::findOne(['user_id' => $user->id]);

        if($user->data && $user->data->image) $user->data->image = Image::userImage($user->data->image);

        return $this->view->render('account/account', ['user' => $user]);

    }
    

    public function userData()
    {

        $userData = new UserData;

        $userData->user_id = $this->session->get('user');

        $data = UserData::findOne(['user_id' => $userData->user_id])->toEdit();

        if($data) $userData->data($data);

        if ($this->request->post()) {

            if($this->request->file('image')){

                $uploader = $userData->setImage(new Uploader(USER_IMG_ROOT));

                if($uploader->error) $this->session->setFlash('danger', $uploader->error);

            }

            $userData->data($this->request->body());
            
            if ($userData->validate() && ($data ? $userData->update(['user_id' => $userData->user_id]) : $userData->save())) {

                $this->session->setFlash('success', 'Zaktualizowano pomyślnie');

            } else {

                $this->session->setFlash('danger', $userData->getFirstError());

            }

        }

        return $this->view->render('account/data', [
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

        return $this->view->render('account/password', [
            'model' => $user
        ]);

    }

    public function approvals()
    {
        $model = new UserApprovals;

        $model->user_id = $this->session->get('user');

        $model->registerApprovals = Approvals::findAll([], ['id' => 'DESC']);

        if ($this->request->post()) {

            $model->data($this->request->body());

            if($model->validate()){
                
                if($model->delete(['user_id' => $model->user_id])) $model->save();
                
            } else {

                $this->session->setFlash('danger', $model->getFirstError());

            }

        }

        $model->userApprovals = UserApprovals::findAll(['user_id' => $model->user_id]);

        return $this->view->render('account/approvals', [
            'model' => $model
        ]);

    }

    public function userDelete()
    {

        $userDelete = new UserDelete;

        $delete = UserDelete::findOne(['user_id' => $this->session->get('user')]);

        $user = User::findOne(['id' => $this->session->get('user')]);

        if($this->request->post() && $user)
        {

            if(!$delete){

                $userDelete->data($this->request->body());
    
                if(password_verify($userDelete->password, $user->password)){
    
                    $userDelete->user_id = $user->id;
    
                    if($userDelete->save()){
    
                        $userDelete->password = '';
    
                        $this->session->setFlash('success', 'Prośba o usunięcie konta została pomyślnie wysłana i zostanie rozpatrzona najszybciej jak to możliwe.');
    
                    }
    
                } else {
    
                    $this->session->setFlash('danger', 'Podano nieprawidłowe hasło');
    
                }

            } else {

                $this->session->setFlash('warning', 'Prośba usunięcie konta została już wysłana. Zostanie rozpatrzona najszybciej jak to możliwe.');

            }

        }

        return $this->view->render('account/delete',[
            'delete' => $delete,
            'model' => $userDelete
        ]);

    }

    public function userReviews()
    {

        $reviews = Review::findAll(['profile_id' => $this->session->get('user'), 'status' => 1], ['id' => 'DESC']);

        if($reviews) $reviews = array_map(function($review){

            $review->user = User::getUserData($review->user_id);
            return $review;
            
        },$reviews);

        return $this->view->render('account/reviews', [
            'reviews' => $reviews
        ]);

    }

}