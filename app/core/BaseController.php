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
     * Render twig template
     * @param $filePath
     */
    public function render($filePath){
        try{
            if(strpos($filePath, '/') === 0){
                // if the give file path start with /, then remove it
                $filePath = substr($filePath, 1);
            }
            if(strpos($filePath,self::VIEW_TEMPLATE_EXT) === false){
                // if no extension name, add it
                $filePath .= self::VIEW_TEMPLATE_EXT;
            }

            echo $this->loadTemplateFile()->render($filePath, $this->dataForView);
            exit(0);
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