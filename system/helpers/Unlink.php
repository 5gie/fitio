<?php

namespace app\system\helpers;

Class Unlink{

    private string $path;
    private bool $crop;
    const CROPPED_IMAGE_NAME = '-300x300';

    public function __construct($path, $crop = false)
    {
        $this->path = $path;

        $this->crop = $crop;
        $this->deleteImage();
    }

    public function deleteImage()
    {

        if(!file_exists($this->path)){
            
            //TODO: error_log
            
        } else if (!unlink($this->path)){

            //TODO: error_log

        }

        if($this->crop && !$this->deleteCrop()){

            // TODO: error_log

        }

    }

    public function deleteCrop(): bool
    {

        $file = basename($this->path);
        $file_extension = pathinfo($file, PATHINFO_EXTENSION);

        $explode = explode('.', $this->path);

        if(!isset($explode[0])) return null;

        $cropped = $explode[0].self::CROPPED_IMAGE_NAME.'.'.$file_extension;

        if(empty($cropped)) return false;
        
        if(!file_exists($cropped)) return false;

        if(!unlink($cropped)) return false;

        return true;
       
    }

}