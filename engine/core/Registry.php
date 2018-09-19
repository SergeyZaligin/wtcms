<?php declare(strict_types=1);

namespace engine;

/**
 * Class Registry for realise pattern reestr
 *
 * @author Sergey
 */
class Registry 
{
    /**
     * Include trait TSingletone
     */
    use TraitSingletone;
    
    /**
     * For properties
     * 
     * @var array
     */
    protected static $properties = []; 
    
    /**
     * Set property
     * 
     * @param string $name
     * @param string $value
     */
    public function setProperty($name, $value): void
    {
        self::$properties[$name] = $value;
    }
    /**
     * Get property
     * 
     * @param string $name
     * @return mixed string|null
     */
    public function getProperty($name) 
    {
        return self::$properties[$name] ?? null;
    }
    
    /**
     * Get all properties
     * 
     * @return array
     */
    public function getProperties(): array
    {
        return self::$properties;
    }
}
