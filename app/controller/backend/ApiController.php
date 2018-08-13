<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 10/8/18
 * Time: 5:35 PM
 */

namespace App\controller\backend;
use App\core\BaseController;
use App\core\JsonBuilder;
use Klein\Request;
use Klein\Response;
use App\models\User;

class ApiController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Search user by give query keyword
     */
    public function users_search(){
        $usersData = User::SearchByEmailOrFirstName(trim($this->request->param('q')));
        if($usersData && count($usersData) > 0){
            echo JsonBuilder::Success($usersData);
        }else{
            echo JsonBuilder::Error();
        }
    }
}