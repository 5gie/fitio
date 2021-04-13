<?php

namespace app\models;

use app\models\User;
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
        
        $user = User::findOne(['email' => $this->email, 'status' => 1]);

        if(!$user || !password_verify($this->password, $user->password)){

            $this->addError('Błędny login lub hasło');
            return false;

        }

        if($user->banned == 1) {

            $this->addError('Twoje konto zostało zbanowane');
            return false;

        }

        if($user->status == 0) {

            $this->addError('Twój adres e-mail nie został potwierdzony, sprawdź swoją skrzynke mailową');
            return false;

        }

        if($user->reset == 1) {

            $this->addError('Twoje konto zostało zresetowane, sprawdź swoja skrzynke mailową');
            return false;

        }

        $this->id = $user->id;

        return true;
        
    }

    public function getParam($param){

        if(property_exists($this, $param)) return $this->{$param};

    }

}