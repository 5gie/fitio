<?php

namespace app\models;

use app\system\UserModel;

class User extends UserModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public int $id;
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $password2 = '';
    public ?array $approvals = [];
    public array $registerApprovals;
    
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

        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->id = parent::save();

        return $this->id;
    }
    
    public function rules(): array
    {

        return [
            'email' => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL, 
                [
                    self::RULE_UNIQUE,
                    'class' => self::class,
                    // 'attribute' => 'email' 
                ]
            ],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'password2' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'approvals' => [self::RULE_APPROVAL]
        ];

    }

    public function attributes(): array
    {
        return ['email', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'email' => 'E-mail',
            'password' => 'Password',
            'password2' => 'Confirm password'
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function insertApprovals()
    {
        $userApprovals = new UserApprovals;

        if($this->approvals){

            foreach($this->approvals as $approval_id => $selected){

                $userApprovals->approval_id = $approval_id;
                $userApprovals->user_id = $this->id;

                $userApprovals->save();

            }
        }

    }
}