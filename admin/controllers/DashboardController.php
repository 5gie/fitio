<?php

namespace admin\controllers;

use app\system\AdminController;

class DashboardController extends AdminController
{
    
    public function __construct(){

        parent::__construct();

    } 

    public function dashboard()
    {
        return $this->view->render('dashboard');
    }



}