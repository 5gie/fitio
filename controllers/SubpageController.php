<?php

namespace app\controllers;

use app\models\Subpage;
use app\system\Controller;

class SubpageController extends Controller
{

    private Subpage $subpage;
    
    public function __construct(){

        parent::__construct();

    } 

    public function subpage($seo)
    {

        if(!$this->getSubpage($seo)) return;

        $title = !empty($this->subpage->meta_title) ? $this->subpage->meta_title : $this->subpage->title;

        $this->view->setMeta($title, $this->subpage->meta_desc, $this->subpage->meta_keywords);

        $this->view->render('subpage', ['subpage' => $this->subpage]);

    }

    public function notFound()
    {

        $this->response->setStatusCode(404);
        $this->view->render('404');

    }

    public function getSubpage($seo): bool
    {

        $subpage = Subpage::findOne(['seo' => $seo]);

        if(!$subpage) {

            $this->notFound();
            return false;

        } else {

            $this->subpage = $subpage;

            return true;

        }

    }


}