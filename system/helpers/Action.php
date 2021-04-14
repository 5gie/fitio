<?php

namespace app\system\helpers;

Class Action {

    public string $title;
    public string $classList;
    public string $id;
    public string $options;
    public string $type;

    public function __construct($type = '', $title = '', $classList = '', $options = '', $id = '')
    {
        $this->title = $title;
        $this->classList = $classList;
        $this->options = $options;
        $this->id = $id;
        $this->type = $type;
    }

}