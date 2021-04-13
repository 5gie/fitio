<?php

namespace app\system;
use app\config\ConfigRoutes;

class App 
{
    
    public static string $ROOT_DIR;

    // public string $userClass;
    public static App $app;
    public Database $db;

    public function __construct($root, array $config, $run = false)
    {

        // $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $root;
        self::$app = $this;
        $this->db = new Database($config['db']);

        // $primaryValue = $this->session->get('user');
        // if($primaryValue){
        //     $primaryKey = $this->userClass::primaryKey();
        //     $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        // } else {
        //     $this->user = null;
        // }

        if ($run) new ConfigRoutes;

    }


    // public function login(UserModel $user)
    // {
    //     $this->user = $user;
    //     $primaryKey = $user::primaryKey();
    //     $primaryValue = $user->{$primaryKey};
    //     $this->session->set('user', $primaryValue);
    //     return true;
    // }

    // public function logout()
    // {
    //     $this->user = null;
    //     $this->session->remove('user');
    // }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }


}