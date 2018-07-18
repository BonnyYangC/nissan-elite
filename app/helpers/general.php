<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 18/7/18
 * Time: 5:34 PM
 */

if(!function_exists('env')){
    function env($key, $default=false){
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/../../.env');
        $dotenv->load();

        return getenv($key) ? getenv($key) : $default;
    }
}