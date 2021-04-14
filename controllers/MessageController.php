<?php

namespace app\controllers;

use app\models\Conversation;
use app\models\Message;
use app\models\User;
use app\system\Controller;

class MessageController extends Controller
{

    private User $sender;
    private User $recipient;
    private Conversation $conversation;

    public function __construct()
    {
        parent::__construct();

        if(!$this->checkAuth()) return;
    }

    public function newConversation($id)
    {

        $conversation = new Conversation;
        $message = new Message;

        if(!$this->getUser($id)) return;

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



        return $this->view->render('profile/new_conversation', [
            'conversation' => $conversation,
            'message' => $message,
            'user' => $this->user->id
        ]);
        
    }

    public function listConversations()
    {

        $conversations = Conversation::getList($this->session->get('user'));

        if($conversations) $conversations = $this->mapConversationMessages($conversations);

        return $this->view->render('account/conversation/list', [
            'conversations' => $conversations
        ]);

    }

    public function mapConversationMessages(array $conversations): array
    {

        $conversations = array_map(function($conversation) {
    
            $conversation->message = Message::findOne(['conversation_id' => $conversation->id], ['id' => 'ASC']);

            if($conversation->sender != $this->session->get('user')) $conversation->user = User::findOne(['id' => $conversation->sender]);

            if($conversation->recipient != $this->session->get('user')) $conversation->user = User::findOne(['id' => $conversation->recipient]);

            return $conversation;

        }, $conversations);

        return $conversations;

    }

    public function conversationAuth():bool
    {
        return $this->conversation->sender == $this->session->get('user') || $this->conversation->recipient == $this->session->get('user');
    }

    public function conversation($conversation_id)
    {

        $model = new Message;

        $messages = [];

        $this->conversation = Conversation::findOne(['id' => $conversation_id]);

        if($this->conversation && $this->conversationAuth()){

            $model->conversation_id = $this->conversation->id;

            if($this->setConversationUsers()){

                if($this->request->post()) $this->sendConversationMessage($model);

                $messages = Message::findAll(['conversation_id' => $conversation_id], ['id' => 'DESC'], 0, 3);

                if($messages) $messages = $this->mapMessages($messages);

            } else {

                $this->session->setFlash('error', 'Użytkownik nie istnieje lub został usunięty.');

                $this->response->referer();

            }

        } else {

            $this->session->setFlash('error', 'Taka konwersacja nie istnieje lub została usunięta.');

            $this->response->redirect('/');

        }

        return $this->view->render('account/conversation', [
            'conversation' => $this->conversation,
            'messages' => $messages,
            'model' => $model,
            'sender' => $this->sender,
            'recipient' => $this->recipient
        ]);
        

    }

    public function setConversationUsers(): bool
    {

        $this->sender = User::findOne(['id' => $this->conversation->sender]);
        $this->recipient = User::findOne(['id' => $this->conversation->recipient]);

        return $this->sender && $this->recipient ? true : false;

    }

    public function sendConversationMessage(Message $model)
    {

        $model->data($this->request->body());
        $model->user_id = $this->session->get('user');

        if ($model->validate() && $model->save()) {

            $model->content = '';

            $this->session->setFlash('success', 'Wiadomość została pomyślnie wysłana');

        } else {

            $this->session->setFlash('danger', $model->getFirstError());

        }

    }

    public function mapMessages(array $messages): array
    {
        $messages = array_reverse(array_map(function($msg){

            $msg->user_msg = $msg->user_id == $this->session->get('user') ? true : false;

            $msg->user_type = $msg->user_id == $this->sender->id ? 'sender' : 'recipient'; 

            return $msg;

        }, $messages));

        return $messages;

    }

}
