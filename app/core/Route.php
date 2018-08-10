<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 19/7/18
 * Time: 11:23 AM
 */

namespace App\core;

use Klein\App;
use Klein\Klein;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;

class Route
{
    private $pool = [];

    /**
     * Default redirect to path
     * @var string
     */
    public $redirectTo = '/home';

    /**
     * @var Route null
     */
    private static $_INSTANCE = null;

    /**
     * @var Klein null
     */
    private $_router = null;

    private function __construct()
    {
        $this->_router = new Klein();
    }

    /**
     * Get instance
     * @return Route
     */
    public static function Instance(){
        if(is_null(self::$_INSTANCE)){
            self::$_INSTANCE = new Route();
        }
        return self::$_INSTANCE;
    }

    public function getPool(){
        return $this->pool;
    }

    /**
     * 根据给定的 name 返回 url 路由
     * @param $routeName
     * @return null|string
     */
    public function path($routeName){
        $path = null;
        foreach ($this->pool as $route) {
            if($route['routeName'] == $routeName){
                $path = url($route['path']);
                break;
            }
        }
        return $path;
    }

    /**
     * Give the last route in the pool a name
     * @param $routeName
     * @return $this
     */
    public function name($routeName){
        // Get the last route from pool
        $route = count($this->pool)>0 ?
            $this->pool[count($this->pool) -1] : null;

        if($route){
            $this->pool[count($this->pool) -1]['routeName'] = $routeName;
        }

        return $this;
    }

    /**
     * Push a new path to the routes pool
     * @param $path
     */
    private function _pushToPool($path){
        $this->pool[] = [
            'path'=>$path,
            'routeName'=>null
        ];
    }

    /**
     * Handle All Get type request
     * @param $path
     * @param $controller
     * @param $action
     * @return Route
     */
    public function get($path,$controller,$action){
        $this->_pushToPool($path);

        $this->_router->respond(
            'GET',
            $path,
            function(Request $request, Response $response, ServiceProvider $service, App $app) use ($controller, $action){
                $c = new $controller($request,$response,$service, $app);
                $c->$action();
            }
        );
        return $this;
    }

    /**
     * Handle All Post type request
     * @param $path
     * @param $controller
     * @param $action
     * @return $this
     */
    public function post($path,$controller,$action){
        $this->_pushToPool($path);

        $this->_router->respond(
            'POST',
            $path,
            function(Request $request, Response $response, ServiceProvider $service, App $app) use ($controller, $action){
                $c = new $controller($request, $response, $service, $app);
                $redirectTo = $c->$action();
                if($redirectTo){
                    $response->redirect($redirectTo)->send();
                }
            }
        );
        return $this;
    }

    public function all($path,$controller,$action){
        $this->_pushToPool($path);

        $this->_router->respond(
            ['POST','GET','PUT','DELETE'],
            $path,
            function(Request $request, Response $response, ServiceProvider $service, App $app) use ($controller, $action){
                $c = new $controller($request, $response, $service, $app);
                $redirectTo = $c->$action();
                if($redirectTo){
                    $response->redirect($redirectTo)->send();
                }
            }
        );
        return $this;
    }

    /**
     * the point of dispatch route
     */
    public function dispatch(){
        $this->_router->dispatch();
    }

    /**
     * Define a group of routes
     * @param $groupName
     * @param \Closure $closure
     */
    public function group($groupName, $closure){
        $this->_router->with($groupName, $closure() );
        $this->_router->dispatch();
    }

    public function redirect($url, $params = []){
//        $resp = new Response();
//        $resp->redirect($url);
        return $this->_router->response()->redirect($url)->send();
    }
}