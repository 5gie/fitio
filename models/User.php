<?php

namespace app\models;

use app\system\DbModel;

class User extends DbModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    const TYPE_USER = 1;
    const TYPE_COMPANY = 2;

    public int $id;
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public int $type = self::TYPE_USER;
    public int $banned = 0;
    public $data = false;
    public int $reset = 0;
    public ?string $ckey;
    public string $password = '';
    public string $password2 = '';
    public ?array $approvals = [];
    public array $registerApprovals = [];
    public ?float $rating;

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
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'password2' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'approvals' => [self::RULE_APPROVAL],
            'type' => [self::RULE_REQUIRED, self::RULE_INT, [self::RULE_INT_MIN, 'min' => 1], [self::RULE_INT_MAX, 'max' => 2]]
        ];

    }

    public function attributes(): array
    {
        return ['email', 'password', 'status', 'type', 'ckey'];
    }

    public function labels(): array
    {
        return [
            'email' => 'E-mail',
            'password' => 'Hasło',
            'password2' => 'Potwierdź hasło',
            'type' => 'Zarejestruj jako'
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

    public static function getUserData($user_id)
    {
        return self::findOne(['id' => $user_id])->toRender();
    }

    public function getTypeOptions()
    {

        return [
            1 => [
                'name' => 'Użytkownik',
                'value' => 1,
            ],
            2 => [
                'name' => 'Firma',
                'value' => 2
            ]
        ];

    }

    public function toRender(): User
    {
        $this->data = UserData::findOne(['user_id' => $this->id])->toRender();
        $this->rating = Review::userRating($this->id);

        // TODO: usunac unsety bo nie bedzie hasla tutaj
        unset($this->password);
        unset($this->password2);
        return $this;
    }
}