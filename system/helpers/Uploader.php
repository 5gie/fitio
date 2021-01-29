<?php

namespace app\system\helpers;

use \Upload\Storage\FileSystem;
use \Upload\File;
use Upload\Validation\Extension;
use \Upload\Validation\Mimetype;
use \Upload\Validation\Size;

class Uploader 
{
    
    public string $name;
    public string $error;

    public function addUserImage($dir, $name)
    {

        $path = new FileSystem($dir);

        $file = new File($name, $path);

        $file->addValidations([

            new Mimetype(['image/png', 'image/jpg', 'image/jpeg']),
            new Extension(['png', 'jpg']),
            new Size('5M')

        ]);

        $new_filename = uniqid();
        $file->setName($new_filename);

        $this->name = $new_filename;

        // TODO: resize/convert to webp;

        try {

            $file->upload();

            return true;
            
        } catch (\Exception $e) {

            $this->error = $file->getErrors()[0] ?? false;

            return false;

        }


    }
   

}