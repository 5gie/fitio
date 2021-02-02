<?php

namespace app\models;

use app\system\DbModel;

class Message extends DbModel
{

    public int $id;
    public int $conversation_id;
    public int $user_id;
    public string $content = '';

    public static function tableName(): string
    {
        return 'message';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        return parent::save();
    }

    public function rules(): array
    {
        return ['content' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 20], [self::RULE_MAX, 'max' => 1000]]];
    }

    public function attributes(): array
    {
        return ['conversation_id', 'content', 'user_id'];
    }

    public function labels(): array
    {
        return ['content' => 'Treść wiadomości...'];
    }
}
