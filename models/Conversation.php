<?php

namespace app\models;

use app\system\DbModel;
use PDO;

class Conversation extends DbModel
{

    public int $id;
    public int $sender;
    public int $recipient;
    public ?Message $message;

    public static function tableName(): string
    {
        return 'conversation';
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

        return ['recipient' => [self::RULE_USER]];
    }

    public function attributes(): array
    {
        return ['sender', 'recipient'];
    }

    public function labels(): array
    {
        return [];
    }

    public static function getList($user_id): array
    {
        $tableName = self::tableName();

        $query = '';

        $query = "WHERE sender = :user_id OR recipient = :user_id";

        $stmt = self::prepare("SELECT * FROM $tableName $query");

        $stmt->bindValue(":user_id", $user_id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);

    }

}
