<?php

namespace app\system;

class Request
{

    public function getPath()
    {

        $path = $_SERVER['REQUEST_URI'] ?? '/';
        
        $position = strpos($path, '?');

        if($position === false) return $path;

        return substr($path, 0, $position);

    }

    public function method()
    {

        return strtolower($_SERVER['REQUEST_METHOD']);

    }

    public function get()
    {

        return $this->method() == 'get';

    }

    public function post()
    {

        return $this->method() == 'post';

    }

    public function file($name)
    {

        return isset($_FILES[$name]['name']) && !empty($_FILES[$name]['name']) ? $_FILES[$name] : false;

    }

    public function body()
    {

        $body = [];

        if($this->get()){

            foreach ($_GET as $key => $get) $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);

        }

        if($this->post()){

            foreach($_POST as $key => $post) $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);

            $body['approvals'] = filter_input(INPUT_POST, 'approvals', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        }

        return $body;

    }

    public function getRequestUri()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : false;
    }

}