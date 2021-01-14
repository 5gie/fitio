<?php

namespace app\system;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}