<?php declare(strict_types=1);

namespace engine\base;

/**
 * Class View
 *
 * @author Sergey
 */
class View 
{

    /**
     * Array routes
     * 
     * @var array
     */
    public $route;
    /**
     * Controller name
     * 
     * @var string
     */
    public $controller;
    /**
     * Model name
     * 
     * @var string 
     */
    public $model;
    /**
     * View name
     * 
     * @var string
     */
    public $view;
    /**
     * Prefix name
     * 
     * @var string
     */
    public $prefix;
    /**
     * Data
     * 
     * @var array
     */
    public $data = [];
    /**
     * Meta info
     * 
     * @var array
     */
    public $meta = [
        'title' => '',
        'description' => '',
        'keywords' => ''
    ];
    public $scripts = [];
    /**
     * Constructor view
     * 
     * @param array $route
     */
    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $view;
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        
        if (false === $layout) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
    }
    /**
     * Render view
     * 
     * @param mixed $data
     * @throws \Exception
     * @return void
     */
    public function render($data): void
    {
        if (is_array($data)) {
            extract($data);
        }
        
        $viewFile = APP . '/views/' . $this->prefix . $this->controller . '/' . $this->view . '.php';
        
        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else {
            throw new \Exception("Не найден вид {$viewFile}", 500);
        }
        if (false !== $this->layout) {
            $layoutFile = APP . '/views/layouts/' . $this->layout . '.php';
            if (is_file($layoutFile)) {
                $content = $this->getScript($content);
                $scripts = [];
                if (!empty($this->scripts)) {
                    $scripts = $this->scripts[0];
                }
                require_once $layoutFile;
            } else {
                throw new \Exception("Не найден вид {$layoutFile}", 500);
            }
        }
    }
    /**
     * Get meta tags
     * 
     * @return string
     */
    public function getMeta(): string 
    {
        $output = '';
        
        if (isset($this->meta['description']) || isset($this->meta['keywords']) || isset($this->meta['title'])) {
            $output  =  "<meta name='description' content='{$this->meta['description']}'>" . PHP_EOL;
            $output .=  "<meta name='keywords' content='{$this->meta['keywords']}'>" . PHP_EOL;
            $output .=  "<title>{$this->meta['title']}</title>" . PHP_EOL;
        }
        
        return $output;
    }
    
    protected function getScript($content)
    {
        $pattern = "#<script.*?>.*?</script>#si";
        
        preg_match_all($pattern, $content, $this->scripts);
        
        if(!empty($this->scripts)){
            $content = preg_replace($pattern, '', $content);
        }
        
        return $content;
    }
}
