<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 2:42 PM
 */

namespace App\controller;
use Klein\Request;
use Klein\Response;

class AccountsController extends DashboardController
{
    /**
     * StaticPagesController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function account(){
        $this->dataForView['user'] = $this->userObject;
        $this->render('dashboard/account');
        return;
    }
}