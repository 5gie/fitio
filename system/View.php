<?php 

namespace app\system;

use app\models\Settings;
use app\system\form\Form;

final class View
{

    public string $layout = 'main';
    public array $css = [];
    public array $js = [];
    public ?Form $form;
    public Session $session;
    public Settings $settings;

    public function __construct()
    {
        $this->session = new Session;
        $this->settings = new Settings;
        $this->setSettings();
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $data = [])
    {

        $this->addCss('bootstrap.min.css');
        $this->addCss('all.css');
        $this->addCss('style.less', 'less');

        $this->addJs('main.js');
        $this->addJs('gsap.min.js');
        $this->addJs('bootstrap.min.js');
        $this->addJs('popper.min.js');
        $this->addJs('jquery-3.4.1.min.js');

        $viewContent = $this->renderOnlyView($view, $data);
        $layoutContent = $this->layoutContent();
        $alertsContent = $this->alertsContent();
        $javscriptContent = $this->javscriptContent();
        $cssContent = $this->cssContent();

        $this->form = new Form;

        echo str_replace(['{{content}}','{{alerts}}', '{{css}}', '{{javascript}}'], [$viewContent, $alertsContent, $cssContent, $javscriptContent], $layoutContent);
    }

    protected function alertsContent()
    {

        ob_start();
        include_once App::$ROOT_DIR . "/views/components/alerts.php";
        return ob_get_clean();
    }

    protected function javscriptContent()
    {

        ob_start();
        include_once App::$ROOT_DIR . "/views/components/javascript.php";
        return ob_get_clean();
    }

    protected function cssContent()
    {

        ob_start();
        include_once App::$ROOT_DIR . "/views/components/css.php";
        return ob_get_clean();
    }

    protected function layoutContent()
    {

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

    public function userImage($image, $alt = '')
    {
        if(isset($image)) echo '<img src="'.$image.'" alt="'.$alt.'">';
    }

    public function setMeta($meta_title = '', $meta_desc = '', $meta_keywords = '')
    {
        if(!empty($meta_title)) $this->settings->meta_title = $meta_title;
        if(!empty($meta_desc)) $this->settings->meta_desc = $meta_desc;
        if(!empty($meta_keywords)) $this->settings->meta_keywords = $meta_keywords;
    }

    public function setSettings()
    {

        $this->settings = Settings::getSettings();
        
    }


}