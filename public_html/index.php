<?php
/**
 * Entry point of the NissanAC application
 * User: Justin Wang
 * Date: 23/7/18
 * Time: 11:34 AM
 */
require_once __DIR__ . '/../vendor/autoload.php';
error_reporting(env('DEV_MODE',false) ? E_ERROR : 0);
ini_set('display_errors', env('DEV_MODE',false) ? true : false);

/**
 * Route: /  -> It's the entry point of the application, will render login and 3brands grid view
 */
\App\core\Route::Instance()
    ->get('/',\App\controller\UsersController::class, 'login')
    ->name('homepage');
/**
 * Route: /user/logout  -> Log the current user out safely
 */
\App\core\Route::Instance()
    ->get('/user/logout',\App\controller\UsersController::class, 'logout')
    ->name('user.logout');
/**
 * Route: /user/login  -> Authentication
 */
\App\core\Route::Instance()
    ->post('/user/login',\App\controller\UsersController::class, 'verify_user')
    ->name('user.login.post');

/**
 * Route: /user/login  -> Authentication
 */
\App\core\Route::Instance()
    ->get('/user/reset-my-password',\App\controller\UsersController::class, 'reset_password')
    ->name('user.reset.password');

// Functional modules routes start
/**
 * Route: /dashboard  -> Dashboard view
 */
// static pages
\App\core\Route::Instance()->get('/dashboard',\App\controller\DashboardController::class, 'dashboard');
\App\core\Route::Instance()->get('/dashboard/MembersGuide',\App\controller\StaticPagesController::class, 'members_guide');
\App\core\Route::Instance()->get('/dashboard/Lifetime',\App\controller\StaticPagesController::class, 'lifetime');
\App\core\Route::Instance()->get('/dashboard/FAQ',\App\controller\StaticPagesController::class, 'faq');
\App\core\Route::Instance()->get('/dashboard/MDguild',\App\controller\StaticPagesController::class, 'md_guide');
\App\core\Route::Instance()->get('/dashboard/MDguild-members',\App\controller\StaticPagesController::class, 'md_guide_members');
\App\core\Route::Instance()->get('/dashboard/MDguild-high-achievers',\App\controller\StaticPagesController::class, 'md_guide_high_achievers');
\App\core\Route::Instance()->get('/dashboard/MDguild-high-achievers-winners',\App\controller\StaticPagesController::class, 'md_guide_high_achievers_winners');
\App\core\Route::Instance()->get('/dashboard/MDguild-events',\App\controller\StaticPagesController::class, 'md_guide_events');
\App\core\Route::Instance()->get('/dashboard/MDguild-events-past',\App\controller\StaticPagesController::class, 'md_guide_events_past');
\App\core\Route::Instance()->get('/dashboard/MDguild-events-high-achievers',\App\controller\StaticPagesController::class, 'md_guide_events_high_achievers');
// static pages end
// dynamic pages
\App\core\Route::Instance()->get('/dashboard/ProductChallenge',\App\controller\StaticPagesController::class, 'product_challenge');
\App\core\Route::Instance()->get('/dashboard/ProductChallengeWinners',\App\controller\StaticPagesController::class, 'product_challenge_winner');
\App\core\Route::Instance()->get('/dashboard/ProductChallengeCurrentEvent',\App\controller\StaticPagesController::class, 'product_challenge_current_event');

\App\core\Route::Instance()->get('/dashboard/Account',\App\controller\AccountsController::class, 'account');
\App\core\Route::Instance()->get('/dashboard/Calendar',\App\controller\AccountsController::class, 'calendar');
\App\core\Route::Instance()->get('/dashboard/Incentives',\App\controller\AccountsController::class, 'incentives');
\App\core\Route::Instance()->get('/dashboard/Metrics',\App\controller\AccountsController::class, 'metrics');

// Ajax calls: For get rankings
\App\core\Route::Instance()->get('/dashboard/Leaderboards',\App\controller\RankingsController::class, 'leader_boards');
\App\core\Route::Instance()->get('/dashboard/get-rankings',\App\controller\RankingsController::class, 'get_rankings');

// Admin Only
\App\core\Route::Instance()->get('/admin-panel', \App\controller\backend\AdminController::class,'index');
\App\core\Route::Instance()
    ->post('/admin/importer/csv', \App\controller\backend\AdminController::class,'csv_importer')
    ->name('admin.upload.csv');
\App\core\Route::Instance()
    ->post('/admin/update-env', \App\controller\backend\AdminController::class,'update_env')
    ->name('admin.update.env');

\App\core\Route::Instance()
    ->get('/api/users-search', \App\controller\backend\ApiController::class,'users_search')
    ->name('api.users.search');

\App\core\Route::Instance()
    ->get('/admin/fake-user', \App\controller\backend\AdminController::class,'fake_user')
    ->name('admin.fake.user');

\App\core\Route::Instance()
    ->get('/api/get-menus', \App\controller\backend\ApiController::class,'get_menus')
    ->name('api.get.menu');
/**
 * This is a must do action: dispatch at last
 */
\App\core\Route::Instance()->dispatch();
exit;