<?php

namespace app\system\helpers;

use \Upload\Storage\FileSystem;
use \Upload\File;
use Upload\Validation\Extension;
use \Upload\Validation\Mimetype;
use \Upload\Validation\Size;
use \Upload\Exception\UploadException;
use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;

class Uploader 
{
    
    public string $name;
    public $error = false;
    public string $dir;
    protected string $extension;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function addUserImage($name)
    {

        $path = new FileSystem($this->dir);

        $file = new File($name, $path);

        $file->addValidations([

            new Mimetype(['image/png', 'image/jpg', 'image/jpeg']),
            new Extension(['png', 'jpg', 'jpeg']),
            new Size('5M')

        ]);

        $new_filename = uniqid();
        $file->setName($new_filename);
        $this->extension = $file->getExtension();

        try {
            
            $file->upload();

            $this->name = $file->getNameWithExtension();

            $this->cropImage($new_filename);

            return true;
            
        } catch (UploadException $e) {

            $this->error = $file->getErrors()[0] ?? false;

            return false;

        } catch (\InvalidArgumentException $e) {

            $this->error = $file->getErrors()[0] ?? false;

            return false;

        } catch(ImageResizeException $e){

            error_log('Wystąpił błąd przy zmniejszaniu zdjęcia użytkownika: '.$this->name);

            return true;

        } 

    }

    public function cropImage($new_filename): void
    {

        $cropped = $this->dir.$new_filename.'-300x300.'.$this->extension;

        if(file_exists($this->getFullImagePath()) && copy($this->getFullImagePath(), $cropped)){

            $crop = new ImageResize($cropped);
            $crop->crop(300, 300, true, ImageResize::CROPCENTER);
            $crop->save($cropped);

        }

    }

    public function getFullImagePath(): string
    {
        return $this->dir.$this->name;
    }
   

}