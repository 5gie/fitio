<?php 

namespace app\system;

abstract class View
{

    public string $title = '';
    public string $layout = 'main';
    public array $css = [];
    public array $js = [];

    public function render($view, $data = [])
    {

        $this->addCss('bootstrap.min.css');
        $this->addCss('all.css');
        $this->addCss('style.less', 'less');

        $this->addJs('bootstrap.min.js');
        $this->addJs('popper.min.js');
        $this->addJs('jquery-3.4.1.min.js');

        $viewContent = $this->renderOnlyView($view, $data);
        $layoutContent = $this->layoutContent();
        echo str_replace('{{content}}', $viewContent, $layoutContent);
        // include App::$ROOT_DIR . "/views/$view.php";
    }

    protected function layoutContent()
    {

        // $layout = 'main';
        // $layout = App::$app->controller ? App::$app->controller->layout : App::$app->controller;

        ob_start();
        include_once App::$ROOT_DIR . "/views/layouts/$this->layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $data)
    {

        foreach($data as $key => $value) $$key = $value;

        ob_start();
        include_once App::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
    
    public function addCss($name, $type = 'css')
    {
        $css = [
            'title' => HTTP_SERVER . 'assets/css/' . $name,
            'type' => $type
        ];

        $this->css[] = $css;
    }
    
    public function addJs($name)
    {
        $this->js[] = HTTP_SERVER . 'assets/js/' . $name;
    }

    public function image($name, $alt = false)
    {
        $alt = $alt ?? '';
        return '<img src='.IMG_DIR.$name.'>';
    }


}