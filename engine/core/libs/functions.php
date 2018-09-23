<?php

/**
 * Function for debug
 * 
 * @param mixed $param
 */
function debug($param) 
{
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

/**
 * Function redirect
 * 
 * @param string $http
 */
function redirect ($http = false) 
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    header("Location: {$redirect}");
    exit;
}