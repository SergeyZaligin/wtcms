<?php

namespace engine;

use \RedBeanPHP\R as R;

/**
 * Class Database for work db
 *
 * @author Sergey
 */
class Database 
{
    use TraitSingletone;
    
    /**
     * Constructor Database
     * 
     * @throws \Exception
     */
    public function __construct() 
    {
        $db = require_once CONF . '/config_db.php';
        R::setup( "mysql:host={$db['host']};dbname={$db['dbname']}",
        "{$db['user']}", "{$db['password']}" );
        if (!R::testConnection()) {
            throw new \Exception("Не удалось подключиться к базе данных", 500);
        }
        R::freeze(true);
        if (DEBUG) {
            R::debug(true, 1);
        }
    }

}
