<?php

namespace app\system\exceptions;

class ForbiddenException extends \Exception
{
    protected $message = 'Błąd autoryzacji';
    protected $code = 403;
}