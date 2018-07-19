<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 19/7/18
 * Time: 11:27 AM
 */

namespace App\controller;
use App\core\BaseController as Controller;
use Klein\Request;

class UsersController extends Controller
{
    public function login(Request $request){
        $this->dataForView['name'] = 'Justin';
        $this->dataForView['cars'] = [
            ['brand'=>'nissan','price'=>100],
            ['brand'=>'toyota','price'=>200],
        ];

        $this->render('user/login');
        return;
    }
}