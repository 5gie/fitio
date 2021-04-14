<?php

namespace admin\models;

use app\system\DbModel;

class Admin extends DbModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public int $id;
    public string $email = '';
    public string $name = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $password2 = '';

    public static function tableName(): string
    {
        return 'user';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
    
    public function rules(): array
    {

        return [
            'email' => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL
            ],
            'name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 50]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'password2' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];

    }

    public function attributes(): array
    {
        return ['email', 'name', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'email' => 'E-mail',
            'name' => 'Nazwa',
            'password' => 'Hasło',
            'password2' => 'Potwierdź hasło'
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }


    public function validateEmail()
    {

        $user = self::findOne(['email' => $this->email]);

        if(!$user) return true;
        else $this->addError('Taki adres e-mail jest juz zarejestrowany'); return false;

    }

}