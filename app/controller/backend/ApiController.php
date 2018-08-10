<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 10/8/18
 * Time: 5:35 PM
 */

namespace App\controller\backend;
use App\core\BaseController;
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
        $user = new User();

        $usersData = $user->simpleQuery([
            "OR" => [
                "firstname[~]" => $this->request->param('q'),
                "email[~]" => $this->request->param('q')
            ]
        ]);

        echo json_encode($usersData);
    }
}