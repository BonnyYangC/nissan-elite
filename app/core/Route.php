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

    /**
     * Handle All Get type request
     * @param string $path
     * @param string $controller   The class name of controller
     * @param string $action               The function name you want to run
     */
    public function get($path,$controller,$action){
        $this->_router->respond(
            'GET',
            $path,
            function(Request $request, Response $response, ServiceProvider $service, App $app) use ($controller, $action){
                $c = new $controller($request,$response,$service, $app);
                $c->$action();
            }
        );
    }

    /**
     * Handle All Post type request
     * @param $path
     * @param $controller
     * @param $action
     */
    public function post($path,$controller,$action){
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