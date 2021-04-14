<?php

namespace app\system\middlewares;

use app\system\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public function executeAuth()
    {
        if(!$this->session->get('user')) throw new ForbiddenException();
    }

    
}