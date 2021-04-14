<?php

namespace app\system\exceptions;

class ForbiddenException extends \Exception
{
    protected $message = 'Błąd autoryzacji';
    protected $code = 401;

    public function getStatusCode()
    {
        return $this->code;
    }

}