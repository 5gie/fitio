<?php

namespace app\controllers;

use app\system\Controller;

class ReviewController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->setLayout('profile');
        
    }

}