<?php declare(strict_types=1);

namespace engine\base;

use engine\Database;

/**
 * Class Model
 *
 * @author Sergey
 */
abstract class Model 
{
    /**
     * Attribute model
     * 
     * @var array
     */
    public $attributes = [];
    /**
     * Errors validation
     * 
     * @var array
     */
    public $errors = [];
    /**
     * Rules validation
     * 
     * @var array
     */
    public $rules = [];
    
    /**
     * Constructor Model
     */
    public function __construct() 
    {
        Database::instance();
    }
    
    /**
     * Load data
     * 
     * @param array $data
     */
    public function load(array $data): void
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }
    
    /**
     * Validation data
     * 
     * @param array $data
     * @return boolean
     */
    public function validate(array $data): bool 
    {
        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()) {
            $_SESSION['validate_success'] = 'Вы успешно зарегистроированы!';
            return true;
        } else {
           $this->errors = $v->errors();
           return false;
        }
    }
    
    /**
     * Get all errors
     */
    public function getErrors(): void
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= '<li>';
                $errors .= $item;
                $errors .= '</li>';
            }
        }
        $errors .= '</ul>';
        $_SESSION['validate_errors'] = $errors;
    }
}
