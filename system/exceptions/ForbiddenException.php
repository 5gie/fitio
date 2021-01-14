<?php

namespace app\system\exceptions;

class ForbiddenException extends \Exception
{
    protected $message = 'Yout dont have permission to access this page';
    protected $code = 403;
}