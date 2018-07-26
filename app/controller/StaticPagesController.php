<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 12:25 PM
 */

namespace App\controller;
use Klein\Request;
use Klein\Response;

/**
 * This controller is for load static page's view
 * Class StaticPagesController
 * @package App\controller
 */
class StaticPagesController extends DashboardController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function members_guide(){
        $this->render('dashboard/members_guide');
        return;
    }
}