<?php

namespace app\system\helpers;

class Uploader 
{
    
    public string $name;
    public string $error;

    public function addUserImage($file)
    {
        
        $this->name = $file['name'];

        return true;
        
    }

}