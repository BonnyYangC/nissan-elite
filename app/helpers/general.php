<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 18/7/18
 * Time: 5:34 PM
 */

if(!function_exists('env')){
    /**
     * @param $key
     * @param bool $default
     * @return array|bool|false|string
     */
    function env($key, $default=false){
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        $dotenv->load();
        return getenv($key) ? getenv($key) : $default;
    }
}

if(!function_exists('view_path')){
    /**
     * Build absolute file path for view files. If $filePath is null, return the root of view files folder
     * @param null $filePath
     * @return string
     */
    function view_path($filePath = null){
        $vPath = env('VIEW_PATH');
        if($filePath){
            if(strpos($filePath, '/') === 0){
                // if the give file path start with /, then remove it
                $filePath = substr($filePath, 1);
            }
            if(strpos($filePath,'.twig') === false){
                $filePath .= '.twig';
            }
        }
        return $filePath ? $vPath.$filePath : $vPath;
    }
}

if(!function_exists('cache_path')){
    /**
     * Build absolute path for twig cache
     * @return bool|string
     */
    function cache_path(){
        $appPath = env('APP_PATH',false);
        if($appPath){
            return $appPath.env('CACHE_PATH','cache');
        }else{
            return false;
        }
    }
}

if(!function_exists('asset')){
    /**
     * Build absolute url for js, css and images
     * @param $filePath
     * @return string
     */
    function asset($filePath){
        if(strpos($filePath,'/') === 0){
            $filePath = substr($filePath,1);
        }
        return env('SITE_URL').$filePath;
    }
}

if(!function_exists('url')){
    /**
     * Build url for js, css and images
     * @param string $uri
     * @return string
     */
    function url($uri=null){
        return env('SITE_URL').$uri;
    }
}

if(!function_exists('dump')){
    function dump($str){
        echo '<pre>';
        var_dump($str);
        echo '</pre>';
    }
}

if(!function_exists('dd')){
    function dd($str){
        dump($str);
        die();
    }
}