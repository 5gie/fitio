<?php

namespace app\controllers;

use app\models\ContactForm;
use app\system\App;
use app\system\Controller;
use app\system\Request;
use app\system\Response;

class SiteController extends Controller
{

    public function home()
    {

        return $this->render('home');
        
    }

    public function contact(Request $request, Response $response)
    {

        $contact = new ContactForm;
        if($request->post()){
            $contact->data($request->body());
            if($contact->validate() && $contact->send()){
                App::$app->session->setFlash('success', 'Thanks for contactiong us.');
                return $response->redirect('/contact');
            }
        }

        return $this->render('contact', [
            'model' => $contact
        ]);
        
    }

    public function handleContact(Request $request)
    {
        debug($request->body());
        // debug($_POST);
    }

}