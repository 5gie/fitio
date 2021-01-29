<?php

namespace app\controllers;

use app\system\Controller;

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