<?php

namespace App\controller;
use App\core\BaseController as Controller;
use App\models\Session;
use Carbon\Carbon;
use Klein\Request;
use Klein\Response;
use App\models\User;

class ApplicationController extends Controller
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function index()
    {
        $this->render('layout/index');
    }
}