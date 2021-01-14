<?php 

namespace app\system;

class View
{

    public string $title = '';

    public function renderView($view, $params = [])
    {

        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once App::$ROOT_DIR . "/views/$view.php";
    }

    protected function layoutContent()
    {

        $layout = App::$app->controller ? App::$app->controller->layout : App::$app->controller;

        ob_start();
        include_once App::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {

        foreach($params as $key => $value) $$key = $value;

        ob_start();
        include_once App::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

}