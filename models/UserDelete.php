<?php

namespace app\models;

use app\system\DbModel;

class UserData extends DbModel
{

    public int $user_id;
    public string $name = '';
    public string $content = '';
    public string $image = '';

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

        return [
            'name' => [[self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 36]],
            'content' => [[self::RULE_MIN, 'min' => 10], [self::RULE_MAX, 'max' => 1000]],
            'image' => [self::RULE_IMAGE],
        ];
    }

    public function attributes(): array
    {
        return ['user_id', 'name', 'content', 'image'];
    }

    public function labels(): array
    {

        // 'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
        return [
            'name' => 'Imię i Nazwisko',
            'content' => 'Twój opis',
            'image' => 'Zdjęcie profilowe / logo firmy'
        ];
    }
}
