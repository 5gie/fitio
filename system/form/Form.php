<?php
namespace app\system\form;

use app\system\Model;

class Form 
{

    public static function begin($action, $method, $files = false)
    {

        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, $files == true ? 'enctype="multipart/form-data"' : '');
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function inputField(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }

    public function textareaField(Model $model, $attribute)
    {
        return new TextareaField($model, $attribute);
    }

    public function approval(Model $model, $attribute)
    {
        return new Approval($model, $attribute);
    }

}