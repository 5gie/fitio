<?php 

namespace app\system;

use app\system\helpers\Action;

class AdminController
{

    public Response $response;
    public Request $request;
    public Session $session;
    public AdminView $view;

    public function __construct(){
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->view = new AdminView;
        $this->checkAuth();
    }

    public function setTitle($title)
    {
        $this->view->title = $title;
    }

    public function addAction(Action $action)
    {
        $this->view->actions[] = $action;
    }

    public function checkAuth()
    {

        if(!$this->session->get('admin') && $this->request->getRequestUri() != '/admin/logowanie'){

            $this->response->setStatusCode(401);

            $this->response->redirect('/admin/logowanie');

            exit;

        }

    }

}