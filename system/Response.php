<?php

namespace app\system;

class Response
{

    public function setStatusCode(int $code)
    {

        http_response_code($code);

    }

    public function redirect(string $url)
    {
        header('Location: '.$url);
    }

    public function referer()
    {

        if(isset($_SERVER['HTTP_REFERER'])) header('location: '.$_SERVER['HTTP_REFERER']);
        else header('location: /');

    }

}