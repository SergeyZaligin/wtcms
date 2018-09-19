<?php declare(strict_types=1);

namespace engine;

/**
 * Trait TraitSingletone realise pattern singletone 
 *
 * @author Sergey
 */
trait TraitSingletone 
{
    /**
     * Instance object realise pattern singletone
     *  
     * @var object
     */
    public static $instance;
    
    /**
     * Instance new object
     * 
     * @return object
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }   
        return self::$instance;
    }

}
