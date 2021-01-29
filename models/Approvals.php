<?php

namespace app\models;

use app\system\DbModel;

class Approvals extends DbModel
{

    public string $title;
    public int $required = 1;

    public static function tableName(): string
    {
        return 'approvals';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    // public function save()
    // {
    //     return parent::save();
    // }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return ['title', 'required'];
    }
}
