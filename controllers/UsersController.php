<?php

namespace app\controllers;

use app\models\User;
use app\system\Controller;
use JasonGrimes\Paginator;

class UsersController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->view->setLayout('test');

    }

    public function list($page = 1)
    {
        
        $total = User::countAll(['status' => 0, 'banned' => 0, 'reset' => 0]);

        $limit = 10;
        $offset = ($page - 1) * $limit;

        $url = '/uzytkownicy/strona/(:num)';

        $users = User::findAll(
            [
                'status' => 1,
                'banned' => 0,
                'reset' => 0
            ],
            ['id' => 'DESC'],
            $offset,
            $limit
        );

        $paginator = new Paginator($total, $limit, $page, $url);

        return $this->view->render('users/list', [
            'users' => $this->usersToRender($users),
            'paginator' => $paginator
        ]);

    }

    public function usersToRender(?array $users): array
    {

        if(!empty($users)) foreach($users as $user) if(!$user->id == $this->session->get('user')) $user->ToRender();

        return $users ?? false;

    }

}
