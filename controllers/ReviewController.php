<?php

namespace app\controllers;

use app\models\Review;
use app\system\Controller;

class ReviewController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->view->setLayout('profile');

        $this->review = new Review;
        
    }

    public function addReview($id)
    {

        if(!$this->checkAuth()) return;

        if(!$this->getUser($id)) return;

        if($this->request->post()){

            $this->review->data($this->request->body());

            if(!$this->checkReview()) return;
                
            $this->review->profile_id = $this->user->id;
            $this->review->user_id = $this->session->get('user');

            if($this->review->validate() && $this->review->save()){

                $this->session->setFlash('success', 'Dziekujemy, twoja opinia została pomyślnie przesłana, zostanie wyświetlona po rozpatrzeniu prze Administrację.');

                $this->response->redirect('/profil/'.$id.'/opinie');

                return;

            } else {

                $this->session->setFlash('danger', $this->review->getFirstError());
                
            }
            
        }

        return $this->view->render('profile/add_review', [
            'user' => $this->user,
            'model' => $this->review
        ]);

    }

    public function checkReview()
    {

        $getReview = Review::findOne(['user_id' => $this->session->get('user'), 'profile_id' => $this->user->id]);

        if($getReview){

            $this->session->setFlash('danger', 'Ten użytkownik odtrzymał juz opinie od ciebie');

            $this->response->redirect('/profil/' . $this->user->id . '/opinie');
            
            return false;
            
        } else {

            return true;

        }

    }

}