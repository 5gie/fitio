<?php

namespace admin\controllers;

use app\system\AdminController;
use app\system\helpers\Action;

class DashboardController extends AdminController
{
    
    public function __construct()
    {
        parent::__construct();
    } 

    public function dashboard()
    {
        $this->setTitle('Dashboard');
        // $this->addAction(new Action('a', 'test', 'btn-primary', 'href="#"'));

        return $this->view->render('dashboard');
    }



}