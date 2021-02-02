<?php

namespace app\models;

use app\system\DbModel;

class UserApprovals extends DbModel
{

    public int $user_id;
    public int $approval_id;
    public ?array $userApprovals = [];
    public ?array $approvals = [];
    public ?array $registerApprovals = [];


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
        $output = true;
        
        if($this->approvals){
            
            foreach ($this->approvals as $approval => $selected) {

                $this->approval_id = $approval;

                if (!parent::save()) $output = false;
            }
            
        }

        return $output;
        
    }

    public function rules(): array
    {
        return ['approvals' => [self::RULE_APPROVAL]];
    }

    public function attributes(): array
    {
        return ['user_id','approval_id'];
    }

}
