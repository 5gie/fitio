<?php
namespace app\models;
use app\system\Model;

class ContactForm extends Model
{
    public string $title = '';
    public string $email = '';
    public string $content = '';

    public function rules(): array
    {

        return [
            'title' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED]
        ];

    }

    public function labels(): array
    {
        return [
            'title' => 'Enter your subject',
            'email' => 'Enter your email',
            'content' => 'Enter your content'
        ];
    }

    public function send()
    {
        return true;
    }
}