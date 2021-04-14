<?php 

namespace app\system;

use app\system\App;
use app\system\form\Form;

class AdminView
{

    public string $title = '';
    public string $layout = 'main';
    public array $css = [];
    public array $js = [];
    public array $actions = [];
    public ?Form $form;
    public Session $session;

    public function __construct()
    {
        $this->session = new Session;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $data = [])
    {

        $this->addCss('bootstrap.min.css');
        $this->addCss('all.css');
        $this->addCss('admin.less', 'less');

        $this->addJs('bootstrap.min.js');
        $this->addJs('popper.min.js');
        $this->addJs('jquery-3.4.1.min.js');

        $viewContent = $this->renderOnlyView($view, $data);
        $layoutContent = $this->layoutContent();
        $alertsContent = $this->alertsContent();
        $javscriptContent = $this->javscriptContent();
        $cssContent = $this->cssContent();
        $navbarContent = $this->navbarContent();
        $actionsContent = $this->actionsContent();
        $userContent = $this->userContent();

        echo str_replace(
            ['{{content}}','{{alerts}}', '{{css}}', '{{javascript}}', '{{navbar}}', '{{actions}}', '{{user}}'],
            [$viewContent, $alertsContent, $cssContent, $javscriptContent, $navbarContent, $actionsContent, $userContent],
            $layoutContent
        );
    }

    protected function alertsContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/components/alerts.php";
        return ob_get_clean();
    }

    protected function javscriptContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/components/javascript.php";
        return ob_get_clean();
    }

    protected function navbarContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/components/navbar.php";
        return ob_get_clean();
    }

    protected function cssContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/components/css.php";
        return ob_get_clean();
    }

    protected function actionsContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/components/actions.php";
        return ob_get_clean();
    }

    protected function userContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/components/user.php";
        return ob_get_clean();
    }

    protected function layoutContent()
    {

        ob_start();
        include_once App::$ADMIN_DIR . "/views/layouts/$this->layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $data)
    {

        foreach($data as $key => $value) $$key = $value;

        ob_start();
        include_once App::$ADMIN_DIR . "/views/$view.php";
        return ob_get_clean();
    }
    
    public function addCss($name, $type = 'css')
    {
        $this->css[] = [
            'title' => HTTP_SERVER . 'assets/css/' . $name,
            'type' => $type
        ];

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