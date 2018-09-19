<?php declare(strict_types=1);

namespace engine;

/**
 * Main class application App
 *
 * @author Sergey
 */
class App 
{
    /**
     * Object Registry realise pattern reestr
     * 
     * @var oject Registry
     */
    public static $app;
    
    public function __construct() 
    {
        // Get query string
        $query = trim($_SERVER['QUERY_STRING'], '/');
        // Start session
        session_start();
        // Reestr
        self::$app = Registry::instance();
        // add params in reestr
        $this->getParams();
        // error handler exception
        new ErrorHandler();
    }
    
    /**
     * Method getParams write property in $app
     * 
     * @return void
     */
    protected function getParams(): void 
    {
        $params = require_once CONF . '/params.php';
        
        if (!empty($params)&& is_array($params)) {
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }

}
