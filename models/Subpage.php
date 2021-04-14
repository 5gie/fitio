<?php

namespace app\models;

use app\system\DbModel;
use app\system\helpers\Filter;

class Subpage extends DbModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public int $id;
    public string $title;
    public ?string $content;
    public ?string $seo;
    public ?string $meta_title;
    public ?string $meta_desc;
    public ?string $meta_keywords;
    public int $status = self::STATUS_INACTIVE;

    public static function tableName(): string
    {
        return 'subpage';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {

        return [];
    }

    public function attributes(): array
    {
        return ['title', 'content', 'seo', 'meta_title', 'meta_desc', 'meta_keywords', 'status'];
    }

    public function labels(): array
    {
        return [];
    }

    public function toRender(): Subpage
    {

        if($this->id){

            foreach($this->attributes as $attribute) $this->{$attribute} = stripslashes($attribute);
    
            if(!empty($this->content)) $this->content = Filter::html_decode($this->content);

        }

  
        return $this;
    }

}
