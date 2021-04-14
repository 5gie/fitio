<?php

namespace app\models;

use admin\models\Admin;
use app\system\Model;

class Login extends Model
{
    public ?int $id;
    public string $email = '';
    public string $password = '';
    
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Adres e-mail',
            'password' => 'Hasło'
        ];
    }

    public function login()
    {
        
        $admin = Admin::findOne(['email' => $this->email, 'status' => 1]);

        if(!$admin || !password_verify($this->password, $admin->password)){

            $this->addError('Błędny login lub hasło');
            return false;

        }

        if($admin->status == 0) {

            $this->addError('Twój adres e-mail nie został potwierdzony, sprawdź swoją skrzynke mailową');
            return false;

        }

        $this->id = $admin->id;

        return true;
        
    }

    public function getParam($param){

        if(property_exists($this, $param)) return $this->{$param};

    }

}