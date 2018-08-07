<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 6/8/18
 * Time: 5:41 PM
 */

namespace App\controller\backend;

use App\core\BaseController;
use App\models\nissan\DataSource;
use Klein\Request;
use Klein\Response;

class AdminController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function index(){
        $this->dataForView['roles'] = DataSource::$_rolesMap;
        $this->render('backend/index');
        return;
    }
}