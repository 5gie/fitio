<?php

namespace app\models;

use app\models\User;
use app\system\App;
use app\system\Model;

class LoginForm extends Model
{
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
            'email' => 'E-mail',
            'password' => 'Password'
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if(!$user){

            $this->addError('email', 'User doesnt exists');
            return false;

        }

        if(!password_verify($this->password, $user->password)){

            $this->addError('password', 'Password is incorrect');
            return false;
            
        }

        return App::$app->login($user);
        
    }
}