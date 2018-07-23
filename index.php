<?php
/**
 * Entry point of the NissanAC application
 * User: justinwang
 * Date: 23/7/18
 * Time: 11:34 AM
 */
error_reporting(E_ERROR);
ini_set('display_errors', TRUE);
require_once __DIR__ . '/vendor/autoload.php';

\App\core\Route::Instance()->get('/',\App\controller\UsersController::class, 'login');
\App\core\Route::Instance()->get('/home',\App\controller\UsersController::class, 'home');
\App\core\Route::Instance()->post('/user/login',\App\controller\UsersController::class, 'verify_user');