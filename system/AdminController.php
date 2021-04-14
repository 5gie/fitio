<?php 

namespace app\system;

class AdminController
{

    public Response $response;
    public Request $request;
    public Session $session;
    public AdminView $view;

    public string $action = '';
    protected array $middlewares = [];
    
    public function __construct(){
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->view = new AdminView;
    }

    public function checkAuth()
    {

        if(!$this->session->get('user')) return true;
        else return false;
           
    }

}