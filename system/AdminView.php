<?php 

namespace app\system;

use admin\Admin;
use app\system\form\Form;

class AdminView
{

    public string $layout = 'main';
    public array $css = [];
    public array $js = [];
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

        $this->form = new Form;

        echo str_replace(['{{content}}','{{alerts}}', '{{css}}', '{{javascript}}', '{{navbar}}'], [$viewContent, $alertsContent, $cssContent, $javscriptContent, $navbarContent], $layoutContent);
    }

    protected function alertsContent()
    {

        ob_start();
        include_once Admin::$ADMIN_DIR . "/views/components/alerts.php";
        return ob_get_clean();
    }

    protected function javscriptContent()
    {

        ob_start();
        include_once Admin::$ADMIN_DIR . "/views/components/javascript.php";
        return ob_get_clean();
    }

    protected function navbarContent()
    {

        ob_start();
        include_once Admin::$ADMIN_DIR . "/views/components/navbar.php";
        return ob_get_clean();
    }

    protected function cssContent()
    {

        ob_start();
        include_once Admin::$ADMIN_DIR . "/views/components/css.php";
        return ob_get_clean();
    }

    protected function layoutContent()
    {

        ob_start();
        include_once Admin::$ADMIN_DIR . "/views/layouts/$this->layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $data)
    {

        foreach($data as $key => $value) $$key = $value;

        ob_start();
        include_once Admin::$ADMIN_DIR . "/views/$view.php";
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

}