<?php

namespace app\controllers;

use app\models\Review;
use app\models\User;
use app\models\UserData;
use app\system\Controller;

class ProfileController extends Controller
{
    private ?User $user;

    public function __construct()
    {
        parent::__construct();

        $this->setLayout('profile');

    }

    public function checkUser($id){

        $user = User::findOne(['id' => $id]);

        if ($user) {

            $this->user = $user;

            $this->user->data = UserData::findOne(['user_id' => $id]);

            if ($this->user->data && !empty($this->user->data->image)) $this->user->data->image = '/images/user/' . $this->user->data->image;

            return true;

        } else {

            $this->session->setFlash('error', 'Taki użytkownik nie istnieje lub został usunięty.');

            $this->response->redirect('/');

        }

    }

    public function auth($id)
    {
        if($this->session->get('user') == $id) $this->response->redirect('/konto');
    }

    public function profile($id)
    {
        
        if($this->checkUser($id)){

            return $this->render('profile/profile', [
                'user' => $this->user
            ]);

        }

    }

    public function userImage($image): void
    {
        if(!empty($image)) echo "<img src='$image'/>";
    }

    public function reviews($id)
    {

        if ($this->checkUser($id)) {

            $this->user->reviews = Review::getReviews(['profile_id' => $this->user->id]);

            return $this->render('profile/reviews', [
                'user' => $this->user
            ]);

        }
        
    }

    public function addReview($id)
    {

        if($this->session->get('user')){

            if($this->checkUser($id)){
    
                $review = new Review;
    
                if($this->request->post()){
    
                    $review->data($this->request->body());
    
                    $getReview = Review::findOne(['user_id' => $this->session->get('user'), 'profile_id' => $this->user->id]);
    
                    if(!$getReview){
    
                        $review->profile_id = $this->user->id;
                        $review->user_id = $this->session->get('user');
    
                        if($review->validate() && $review->save()){
    
                            $this->session->setFlash('success', 'Dziekujemy, twoja opinia została pomyślnie przesłana, zostanie wyświetlona po rozpatrzeniu prze Administrację.');
    
                            $this->response->redirect('/profil/'.$id.'/opinie');
    
                        } else {
    
                            $this->session->setFlash('danger', $review->getFirstError());
                            
                        }
    
                    } else {
    
                        $this->response->redirect('/profil/' . $id . '/opinie');
    
                        $this->session->setFlash('danger', 'Ten użytkownik odtrzymał juz opinie od ciebie');
    
                    }
    
                }
    
                return $this->render('profile/add_review', [
                    'user' => $this->user,
                    'model' => $review
                ]);
            }

        } else {

            $this->response->redirect('/logowanie');

            $this->session->setFlash('danger', 'Najpierw musisz się zalogować');
    
        }

    }

}
