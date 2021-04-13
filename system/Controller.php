<?php 

namespace app\system;

use app\system\helpers\Logger;
// use app\system\middlewares\BaseMiddleware;

class Controller extends View
{

    public Response $response;
    public Request $request;
    public Session $session;
    public Logger $logger;

    public string $action = '';
    protected array $middlewares = [];
    
    public function __construct(){
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->logger = new Logger;
    }
 
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    // public function render($view, $params = [])
    // {

    //     return $this->renderView($view, $params);

    // }

    // public function registerMiddleware(BaseMiddleware $middleware)
    // {

    //     $this->middlewares[] = $middleware;

    // }

    // public function getMiddlewares(): array
    // {
    //     return $this->middlewares;
    // }

}