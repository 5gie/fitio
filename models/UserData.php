<?php

namespace app\models;

use app\system\DbModel;
use app\system\helpers\Filter;
use app\system\helpers\Image;
use app\system\helpers\Unlink;
use app\system\helpers\Uploader;

class UserData extends DbModel
{

    public int $user_id;
    public string $name = '';
    public string $content = '';
    public string $image = '';
    public ?string $renderImage;

    public static function tableName(): string
    {
        return 'user_data';
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
        return [
            'name' => 'Imię i Nazwisko',
            'content' => 'Twój opis',
            'image' => 'Zdjęcie profilowe / logo firmy'
        ];
    }

    public function setImage(Uploader $uploader): Uploader 
    {

        if($uploader->addUserImage('image')){

            if($this->image) new Unlink(USER_IMG_ROOT . $this->image, true);
            $this->image = $uploader->name;
            $this->renderImage = Image::userImage($this->image);

        } 

        return $uploader;

    }
    
    public function toRender(): UserData
    {

        if($this->content) $this->content = Filter::html_decode($this->content);
        // TODO: usunac to
        $this->content = str_replace('\n','<br>',$this->content);
        // 
        if(!empty($this->image)) $this->image = Image::userImage($this->image);

        return $this;
    }

    public function toEdit(): UserData
    {

        if($this->content) $this->content = Filter::html_decode($this->content);

        if(!empty($this->image)) $this->renderImage = Image::userImage($this->image);

        return $this;
    }

}
