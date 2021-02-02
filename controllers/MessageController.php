<?php

namespace app\controllers;

use app\models\Conversation;
use app\models\Message;
use app\models\User;
use app\system\Controller;
use app\system\middlewares\AuthMiddleware;
use Exception;

class MessageController extends Controller
{

    public function __construct()
    {

        parent::__construct();

        $middleware = new AuthMiddleware($this->session);

        try {

            $middleware->execute();
        } catch (Exception $e) {

            $this->response->setStatusCode($e->getCode());

            $this->session->setFlash('danger', $e->getMessage());

            $this->response->redirect('/logowanie');

            exit;
        }
    }

    public function newConversation($id)
    {

        $conversation = new Conversation;
        $message = new Message;

        $user = User::findOne(['id' => $id]);

        if($user){

            if ($this->request->post()) {

                $conversation->sender = $this->session->get('user');
                $conversation->recipient = $id;

                if ($conversation->validate() && $conversation->save()) {

                    // TODO: sprawdzic kilka ostatnich wiadomosci do tego uzytkownika zeby nie bylo za duzo

                    $message->conversation_id = $conversation->id;

                    $message->data($this->request->body());

                    $message->user_id = $this->session->get('user');

                    if ($message->validate() && $message->save()) {

                        $this->session->setFlash('success', 'Wiadomość została pomyślnie wysłana');

                        $this->response->redirect("/konto/wiadomosci/$conversation->id");
                        
                    } else {

                        $conversation->delete(['id' => $conversation->id]);

                        $this->session->setFlash('danger', $message->getFirstError());
                    }

                } else {

                    $this->session->setFlash('danger', $conversation->getFirstError());
                }

            }

        } else {

            $this->session->setFlash('error', 'Taki użytkownik nie istnieje lub został usunięty.');

            $this->response->redirect('/');

        }

        return $this->render('profile/new_conversation', [
            'conversation' => $conversation,
            'message' => $message,
            'user' => $user->id
        ]);
        
    }

    public function listConversations()
    {

        $conversations = Conversation::getList($this->session->get('user'));

        if($conversations){

            $conversations = array_map(function($conversation) {
    
                $conversation->message = Message::findOne(['conversation_id' => $conversation->id], ['id' => 'ASC']);

                return $conversation;
    
            }, $conversations);

        }

        return $this->render('account/conversation/list', [
            'conversations' => $conversations
        ]);

    }

    public function conversation($conversation_id)
    {

        $model = new Message;

        $messages = [];

        $sender = false;

        $recipient = false;

        $conversation = Conversation::findOne(['id' => $conversation_id]);

        if($conversation && ($conversation->sender == $this->session->get('user') || $conversation->recipient == $this->session->get('user'))){

            $sender = User::findOne(['id' => $conversation->sender]);
            $recipient = User::findOne(['id' => $conversation->recipient]);

            if($sender && $recipient){

                if($this->request->post()){

                    $model->conversation_id = $conversation->id;
                    $model->data($this->request->body());
                    $model->user_id = $this->session->get('user');

                    if ($model->validate() && $model->save()) {

                        $model->content = '';

                        $this->session->setFlash('success', 'Wiadomość została pomyślnie wysłana');

                    } else {

                        $this->session->setFlash('danger', $model->getFirstError());

                    }
                    
                }

                $messages = Message::findAll(['conversation_id' => $conversation_id], ['id' => 'DESC'], 0, 3);

                if($messages) {

                    $messages = array_reverse(array_map(function($msg) use ($sender){

                        $msg->user_msg = $msg->user_id == $this->session->get('user') ? true : false;

                        $msg->user_type = $msg->user_id == $sender->id ? 'sender' : 'recipient'; 

                        return $msg;

                    }, $messages));

                }

            } else{

                $this->session->setFlash('error', 'Użytkownik nie istnieje lub został usunięty.');

                $this->response->referer();

            }


        } else {

            $this->session->setFlash('error', 'Taka konwersacja nie istnieje lub została usunięta.');

            $this->response->redirect('/');

        }

        return $this->render('account/conversation', [
            'conversation' => $conversation,
            'messages' => $messages,
            'model' => $model,
            'sender' => $sender,
            'recipient' => $recipient
        ]);
        

    }

}
