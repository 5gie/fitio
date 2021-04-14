<?php 

namespace app\system;

use app\models\User;
use app\system\exceptions\ForbiddenException;
use app\system\helpers\Logger;
use app\system\middlewares\AuthMiddleware;

class Controller extends AuthMiddleware
{

    public Response $response;
    public Request $request;
    public Session $session;
    public Logger $logger;
    public View $view;
    public ?User $user;

    public string $action = '';
    protected array $middlewares = [];
    
    public function __construct(){
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->logger = new Logger;
        $this->view = new View;
    }

    public function checkAuth()
    {
        try{

            $this->executeAuth();

            return true;

        } catch(ForbiddenException $e){

            $this->session->set('request', $this->request->getRequestUri());
            
            $this->session->setFlash('danger', $e->getMessage());
    
            $this->response->setStatusCode($e->getStatusCode());
    
            $this->response->redirect('/logowanie');
    
            return false;

        }


    }

    public function checkNotAuth()
    {
        
        if($this->session->get('user')){

            $this->response->redirect('/');

            return false;

        } else {

            return true;

        }
    }

    
    public function doRedirect($path)
    {

        if(!$this->session->get('request')){

            $this->response->redirect($path);

        } else {

            $request = $this->session->get('request');

            $this->session->remove('request');

            $this->response->redirect($request); 

        }

        return;
        
    }

    
    public function getUser($id){

        $user = User::findOne(['id' => $id])->toRender();

        if ($user) {

            $this->user = $user;

            return true;

        } else {

            $this->session->setFlash('danger', 'Taki użytkownik nie istnieje lub został usunięty.');

            $this->response->redirect('/');
            
            return false;
        }

    }

    

}