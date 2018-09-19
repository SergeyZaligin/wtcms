<?php

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
     */
    public static function dispatch($url) 
    {
        if (self::matchRoute($url)) {
            echo 'yes';
        } else {
            echo 'NO';
        }
    }
    /**
     * Find match url
     * 
     * @param string $url
     * @return bool
     */
    public static function matchRoute(string $url): bool
    {
        return false;
    }
    
    /**
     * Get routes
     * 
     * @return array
     */
    public static function getRoutes() 
    {
        return self::$routes;
    }
    
    /**
     * Get route
     * 
     * @return array
     */
    public static function getRoute() 
    {
        return self::$route;
    }
    
    
}
