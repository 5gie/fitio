<?php

namespace app\models;

use app\system\App;

class Settings
{

    public string $meta_title;
    public string $meta_desc;
    public string $meta_keywords;
    public string $email;
    public string $phone;

    public static function tableName(): string
    {
        return 'settings';
    }

    public function attributes(): array
    {
        return ['meta_title', 'meta_desc', 'meta_keywords', 'email', 'phone'];
    }

    public function toRender(): Settings
    {

        foreach($this->attributes() as $attribute) $this->{$attribute} = stripslashes($this->{$attribute});

        return $this;

    }

    public static function getSettings()
    {

        $stmt = self::prepare("SELECT * FROM ".self::tableName());

        $stmt->execute();
        return $stmt->fetchObject(static::class)->toRender();

    }

    public static function prepare($sql)
    {
        return App::$app->db->pdo->prepare($sql);
    }

}
