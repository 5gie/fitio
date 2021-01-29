<?php

namespace app\system\middlewares;


use app\system\exceptions\ForbiddenException;
use app\system\Session;

class AuthMiddleware extends BaseMiddleware
{

    public Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function execute()
    {

        if(!$this->session->get('user')) throw new ForbiddenException();
     
    }
}