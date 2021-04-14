<?php

namespace app\controllers;

use app\models\Review;
use app\system\Controller;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->view->setLayout('profile');

    }

    public function auth($id)
    {
        if($this->session->get('user') == $id) $this->response->redirect('/konto');
        return;
    }

    public function profile($id)
    {

        if(!$this->getUser($id)) return;

        return $this->view->render('profile/profile', [
            'user' => $this->user
        ]);

    }

    public function reviews($id)
    {

        if (!$this->getUser($id)) return;

        $this->user->reviews = Review::getReviews(['profile_id' => $this->user->id, 'status' => 1]);

        return $this->view->render('profile/reviews', [
            'user' => $this->user
        ]);
        
    }

    

}
