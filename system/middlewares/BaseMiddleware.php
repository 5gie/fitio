<?php

namespace app\system\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}