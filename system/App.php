<?php

namespace app\system;

class App 
{
    
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public static App $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public View $view;
    public ?Controller $controller = null;
    public ?UserModel $user;

    public function __construct($root, array $config)
    {

        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $root;
        self::$app = $this;
        $this->controller = new Controller;
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->view = new View;
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }

    }

    public function run()
    {

        try{
            echo $this->router->resolve();
        } catch(\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->controller->render('error', [
                'exception' => $e
            ]);
        }

    }

    // public function getController(): \app\system\Controller
    // {
    //     return $this->contoller;
    // }

    // public function setController(\app\system\Controller $controller): void
    // {
    //     $this->controller = $controller;
    // }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

}