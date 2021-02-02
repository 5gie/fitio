<?php

namespace app\models;

use app\system\DbModel;

class UserDelete extends DbModel
{

    public int $user_id;
    public int $status = 0;
    public string $password = '';

    public static function tableName(): string
    {
        return 'user_delete';
    }

    public static function primaryKey(): string
    {
        return '';
    }

    public function save()
    {
        return parent::save();
    }

    public function rules(): array
    {

        return [];
    }

    public function attributes(): array
    {
        return ['user_id'];
    }

    public function labels(): array
    {
        return ['password' => 'Wprowadź hasło'];
    }
}
