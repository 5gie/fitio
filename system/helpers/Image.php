<?php

namespace app\system\helpers;

Class Image {

    const CROPPED_IMAGE_NAME = '-300x300';

    public static function userImage($name): string
    {

        $file_extension = pathinfo($name, PATHINFO_EXTENSION);

        $explode = explode('.', $name);

        if(isset($explode[0])){

            $cropped = $explode[0].self::CROPPED_IMAGE_NAME.'.'.$file_extension;

            if(file_exists(USER_IMG_ROOT.$cropped)) return USER_IMG_PATH.$cropped;

        }

        return USER_IMG_PATH.$name;

    }    
   
}