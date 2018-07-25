<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 19/7/18
 * Time: 11:53 AM
 */

namespace App\core;

use Klein\Request;
use Klein\Response;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class BaseController
{
    const TWIG_1 = 'twig1';
    const TWIG_2 = 'twig2';
    const VIEW_TEMPLATE_EXT = '.twig';
    /**
     * @var array To hold all variables which will be used in view
     */
    protected $dataForView = [];
    protected $twigLoader = null;
    protected $debugMode = null;

    /**
     * Hooks before view rendered; function names array
     * @var array
     */
    public $hooksBefore = [
        'beforeRender'  =>null
    ];
    /**
     * Hooks after view rendered; function names array
     * @var array
     */
    public $hooksAfter = [
        'afterRender'   =>null
    ];

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param null $param
     */
    public function beforeRender($param = null){

    }

    /**
     * @param null $param
     */
    public function afterRender($param = null){

    }

    /**
     * Render twig template
     * @param $filePath
     * @param array $hooksBefore
     * @param array $hooksAfter
     */
    public function render($filePath,$hooksBefore=[],$hooksAfter=[]){
        try{
            if(strpos($filePath, '/') === 0){
                // if the give file path start with /, then remove it
                $filePath = substr($filePath, 1);
            }
            if(strpos($filePath,self::VIEW_TEMPLATE_EXT) === false){
                // if no extension name, add it
                $filePath .= self::VIEW_TEMPLATE_EXT;
            }

            /**
             * Execute controller hooks function
             */
            if(!empty($hooksBefore)){
                $this->hooksBefore = array_merge($this->hooksBefore, $hooksBefore);
            }
            if(!empty($hooksAfter)){
                $this->hooksAfter = array_merge($this->hooksAfter, $hooksAfter);
            }
            foreach ($this->hooksBefore as $functionName=>$params) {
                $this->$functionName($params);
            }

            // Hook function is a good place to inject some general data into view
            echo $this->loadTemplateFile()->render($filePath, $this->dataForView);

            /**
             * Execute controller after hooks function
             */
            foreach ($this->hooksAfter as $functionName=>$params) {
                $this->$functionName($params);
            }
        }catch (\Exception $exception){
            dump($exception->getMessage());
            exit(44);
        }
    }

    /**
     * Get twig
     * @return Environment
     */
    private function loadTemplateFile(){
        $loader = new FilesystemLoader(view_path());
        $this->debugMode = env('DEV_MODE', true);

        $options = [
            'debug' => $this->debugMode,
            'cache' => cache_path()
//            'cache' => env('CACHE_PATH', false),
        ];
        $twig = new Environment($loader, $options);

        /**
         * This will allow the php function runnable in twig template
         */
        $twig->addExtension(new PhpFunctionExtension());

        if($this->debugMode){
            $twig->addExtension(new DebugExtension());
        }
        return $twig;
    }
}