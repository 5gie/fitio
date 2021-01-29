<?php

namespace app\system;

class Session 
{

    protected const FLASH_KEY = 'flash';

    public function __construct() 
    { 
        session_start();
        // $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // foreach ($flashMessages as $key => &$flashMessage) {
        //     $flashMessage['remove'] = true;
        // }
        // $_SESSION[self::FLASH_KEY] = $flashMessages;

    }
        
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = $message;
    }

    public function getFlash($key)
    {
        $flash = $_SESSION[self::FLASH_KEY][$key];
        unset($_SESSION[self::FLASH_KEY][$key]);

        return $flash;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}

