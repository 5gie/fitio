<?php

namespace app\system\helpers;

use app\system\DbModel;

class Logger extends DbModel {

    public int $id;
    public string $log = '';

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'logger';
    }

    public function attributes(): array
    {
        return ['log'];
    }

    public function addLog(string $title): bool
    {

        return $this->save($title);

    }

    public function rules(): array
    {

        return [];

    }

}