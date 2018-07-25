<?php
/**
 * Entry point of the NissanAC application
 * User: Justin Wang
 * Date: 23/7/18
 * Time: 11:34 AM
 */
error_reporting(E_ERROR);
ini_set('display_errors', TRUE);
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Route: /  -> It's the entry point of the application, will render login and 3brands grid view
 */
\App\core\Route::Instance()->get('/',\App\controller\UsersController::class, 'login');
/**
 * Route: /user/logout  -> Log the current user out safely
 */
\App\core\Route::Instance()->get('/user/logout',\App\controller\UsersController::class, 'logout');
/**
 * Route: /user/login  -> Authentication
 */
\App\core\Route::Instance()->post('/user/login',\App\controller\UsersController::class, 'verify_user');

// Functional modules routes start
/**
 * Route: /dashboard  -> Dashboard view
 */
\App\core\Route::Instance()->get('/dashboard',\App\controller\DashboardController::class, 'dashboard');

/**
 * This is a must do action: dispatch at last
 */
\App\core\Route::Instance()->dispatch();
exit;