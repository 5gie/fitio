<?php

namespace app\controllers;

use app\models\Approvals;
use app\models\Conversation;
use app\models\Message;
use app\models\Review;
use app\models\User;
use app\models\UserApprovals;
use app\models\UserData;
use app\system\Controller;
use app\system\helpers\Filter;

class SiteController extends Controller
{
    
    public function __construct(){

        parent::__construct();

    } 

    public function home()
    {
        $this->title = 'Fitio';
        $this->addJs('home.js');

        return $this->render('home');
    }

    public function crop()
    {

        

    }

    public function fetch()
    {

        $url = 'https://jsonplaceholder.typicode.com/users';

        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE); // remove body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        $head = curl_exec($ch); 
        curl_close($ch); 

        $images = [
            'adam.jpg',
            'brat.jpg',
            'cezary.jpg',
            'json.jpg',
            'karol.jpg',
            'kubica.jpg',
            'mariusz.jpeg',
            'pawel.jpg',
            'ryba.jpg'
        ];

        foreach(json_decode($head, true) as $json_user){

            $user = new User;

            $user->registerApprovals = Approvals::findAll([], ['id' => 'DESC']);

            $user->ckey = Filter::ckey();
            $user->email = $json_user['email'];
            $user->password = 'testowe123';
            $user->password2 = 'testowe123';

            if($user->validate() && $user->validateEmail() && $user->save()){

                if(!empty($user->id)){

                    $userData = new UserData;

                    $userData->user_id = $user->id;
                    $userData->name = $json_user['name'];
                    $userData->image = $images[rand(0,8)];
                    $userData->content = Filter::html($json_user['address']['street'].' '.$json_user['address']['suite'].' \n '.$json_user['address']['city'].' '.$json_user['address']['zipcode'].' \n '.$json_user['company']['name'].' \n '.$json_user['company']['catchPhrase'].' \n '.$json_user['website']);

                    $userData->validate();
                    $userData->save();

                    $users[] = $user->id;

                } else {

                    debug($user);

                }

            } else {

                debug($user->getFirstError());

            }

            
        }

        foreach($users as $id){

            for($i=0; $i<2; $i++)
            {
                $this->fakeReviews($id);

                $this->fakeConversation($id);

            }

        }

    }

    public function fakeReviews($user_id)
    {

        $review = new Review;
        $profile_id = rand(1,10);
        while($profile_id == $user_id){
            $profile_id = rand(1,10);
        }
        $review->profile_id = $profile_id;
        $review->user_id = $user_id;
        $review->content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat';
        $review->rating = rand(1,5); // TODO: rating na gwiazdki
        $review->validate();
        $review->save();

    }

    public function fakeConversation($user_id)
    {

        $conversation = new Conversation;

        $conversation->sender = $user_id;

        $recipient = rand(1,10);
        while($recipient == $user_id){
            $recipient = rand(1,10);
        }

        $conversation->recipient = $recipient;

        if($conversation->validate() && $conversation->save()){

            for($i=0; $i < rand(1,10); $i++)
            {

                $message = new Message;

                $message->content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat';
                
                $message->conversation_id = $conversation->id;
        
                $test = rand(1,2);

                if($test == 1) $message->user_id = $user_id;
                else $message->user_id = $recipient;

                $message->validate();

                $message->save();

            }

        }

    }

    // public function contact(Request $request, Response $response)
    // {

    //     $contact = new ContactForm;
    //     if($request->post()){
    //         $contact->data($request->body());
    //         if($contact->validate() && $contact->send()){
    //             App::$app->session->setFlash('success', 'Thanks for contactiong us.');
    //             return $response->redirect('/contact');
    //         }
    //     }

    //     return $this->render('contact', [
    //         'model' => $contact
    //     ]);
        
    // }

    // public function handleContact(Request $request)
    // {
    //     debug($request->body());
    //     // debug($_POST);
    // }

}