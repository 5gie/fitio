<?php

namespace app\models;

use app\system\DbModel;

class UserApprovals extends DbModel
{

    public int $user_id;
    public int $approval_id;

    public static function tableName(): string
    {
        return 'user_approvals';
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
        return ['user_id','approval_id'];
    }

}
