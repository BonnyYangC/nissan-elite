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

    public function users_search(){

//        $usersData = $user->simpleQuery([
//            "OR" => [
//                "firstname[~]" => $this->request->param('q'),
//                "email[~]" => $this->request->param('q')
//            ]
//        ]);

        $usersData = User::SearchByEmailOrFirstName(trim($this->request->param('q')));
        if($usersData && count($usersData) > 0){
            echo JsonBuilder::Success($usersData);
        }else{
            echo JsonBuilder::Error();
        }
    }
}