<?php declare(strict_types=1);

namespace engine;

/**
 * Router app
 *
 * @author Sergey
 */
class Router 
{
    /**
     * Table routes
     * 
     * @var array
     */
    protected static $routes = [];
    
    /**
     * Current route
     * 
     * @var array
     */
    protected static $route = [];
    
    /**
     * Add route
     * 
     * @param regexp $regexp
     * @param array $route
     */
    public static function add(string $regexp, array $route = []): void 
    {
        self::$routes[$regexp] = $route;
    }
    
    /**
     * Dispatch url,if matchRoute return true and run controller action
     * 
     * @param string $url
     * @throws \Exception
     */
    public static function dispatch(string $url): void 
    {
        // get query string params
        $url = self::removeQueryString($url);
        
        if (self::matchRoute($url)) {
            
            $controller = 'app\controllers\\' . self::$route['prefix'] 
                        . self::$route['controller'] . 'Controller';
            
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                    $controllerObject->getView();
                } else {
                    throw new \Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            throw new \Exception('Страница не найдена', 404);
        }
    }
    
    /**
     * Find match url
     * 
     * @param mixed string|null $url
     * @return bool
     */
    public static function matchRoute($url): bool
    {
        
        // iteration on table routes
        foreach (self::$routes as $pattern => $route) {
            // find coincidence $pattern with $url and if true write value in $matches
            if (preg_match("#$pattern#", (string)$url, $matches)) {
                // rebuild array $match in string key (except int) 
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value; 
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                //debug(self::$route);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Handler string type of page-one PageOne
     * 
     * @param string $name
     * @return string
     */
    protected static function upperCamelCase(string $name): string 
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }
    
    /**
     * Handler string indexAction
     * 
     * @param string $name
     * @return string
     */
    protected static function lowerCamelCase(string $name): string 
    {
        return lcfirst(self::upperCamelCase($name));
    }
    
    /**
     * Handler string indexAction
     * 
     * @param string $name
     * @return mixed string|false
     */
    protected static function removeQueryString(string $url) 
    {
        if ($url) {
            $params = explode('&', $url , 2);
            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }
    
}
