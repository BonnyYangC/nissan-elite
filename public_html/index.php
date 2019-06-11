<?php
/**
 * Entry point of the NissanAC application
 * User: Justin Wang
 * Date: 23/7/18
 * Time: 11:34 AM
 */
require_once __DIR__ . '/../vendor/autoload.php';
error_reporting(env('DEV_MODE',true) ? E_ERROR : 0);
ini_set('display_errors', env('DEV_MODE',false) ? true : false);

/**
 * Route: /  -> It's the entry point of the application, will render login and 3brands grid view
 */
\App\core\Route::Instance()
    ->get('/',\App\controller\UsersController::class, 'login')
    ->name('homepage');

/**
 * Route: /  -> It's the entry point of the application, will render login and 3brands grid view
 */
\App\core\Route::Instance()
    ->get('/videos',\App\controller\UsersController::class, 'nissan_videos')
    ->name('videos_nissan');

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
\App\core\Route::Instance()->get('/Dashboard',\App\controller\DashboardController::class, 'dashboard');
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

\App\core\Route::Instance()->get('/dashboard/current-status-level',\App\controller\GageController::class, 'current_status_level');

// static pages end
// dynamic pages
\App\core\Route::Instance()->get('/dashboard/ProductChallenge',\App\controller\StaticPagesController::class, 'product_challenge');
\App\core\Route::Instance()->get('/dashboard/ProductChallengeWinners',\App\controller\StaticPagesController::class, 'product_challenge_winner');
\App\core\Route::Instance()->get('/dashboard/ProductChallengeCurrentEvent',\App\controller\StaticPagesController::class, 'product_challenge_current_event');

\App\core\Route::Instance()->get('/dashboard/Account',\App\controller\AccountsController::class, 'account');
\App\core\Route::Instance()->get('/dashboard/Calendar',\App\controller\AccountsController::class, 'calendar');
\App\core\Route::Instance()->get('/dashboard/Incentives',\App\controller\AccountsController::class, 'incentives');
\App\core\Route::Instance()->get('/dashboard/Metrics',\App\controller\AccountsController::class, 'metrics');
\App\core\Route::Instance()->get('/my-team',\App\controller\AccountsController::class, 'my_team');

// Ajax calls: For get rankings
\App\core\Route::Instance()->get('/dashboard/Leaderboards',\App\controller\RankingsController::class, 'leader_boards');
\App\core\Route::Instance()->get('/dashboard/get-rankings',\App\controller\RankingsController::class, 'get_rankings');
\App\core\Route::Instance()->get('/dashboard/print-rankings',\App\controller\RankingsController::class, 'print_rankings');

// Admin Only
\App\core\Route::Instance()->get('/admin-panel', \App\controller\backend\AdminController::class,'index')
    ->name('admin.home');
\App\core\Route::Instance()->get('/admin-fix-historical', \App\controller\backend\AdminController::class,'fix_historical_data_for_credits')
    ->name('admin.fix.historical');
\App\core\Route::Instance()->get('/admin-fix-regional-report', \App\controller\backend\AdminController::class,'sync_regional_report_user_status')
    ->name('admin.fix.regional.report');
\App\core\Route::Instance()->get('/admin-fix-users-password', \App\controller\backend\AdminController::class,'fix_users_password')
    ->name('admin.fix.users.password');
\App\core\Route::Instance()
    ->post('/admin/importer/csv', \App\controller\backend\AdminController::class,'csv_importer')
    ->name('admin.upload.csv');
\App\core\Route::Instance()
    ->post('/admin/update-env', \App\controller\backend\AdminController::class,'update_env')
    ->name('admin.update.env');

\App\core\Route::Instance()
    ->get('/admin/users-manage', \App\controller\backend\UsersController::class,'index')
    ->name('admin.users.manage');
\App\core\Route::Instance()
    ->get('/admin/users-edit', \App\controller\backend\UsersController::class,'user_edit')
    ->name('admin.users.edit');

\App\core\Route::Instance()
    ->post('/admin/users-save', \App\controller\backend\UsersController::class,'user_save')
    ->name('admin.users.save');

/**
 * Routes for manage calendars
 */
\App\core\Route::Instance()
    ->get('/admin/calendars-index', \App\controller\backend\CalendarsController::class,'calendars_index')
    ->name('admin.calendars.index');
\App\core\Route::Instance()
    ->get('/admin/calendars-edit', \App\controller\backend\CalendarsController::class,'calendars_edit')
    ->name('admin.calendars.edit');
\App\core\Route::Instance()
    ->get('/admin/calendars-delete', \App\controller\backend\CalendarsController::class,'calendars_delete')
    ->name('admin.calendars.delete');
\App\core\Route::Instance()
    ->get('/admin/calendar-new', \App\controller\backend\CalendarsController::class,'calendar_new')
    ->name('admin.calendar.new');
\App\core\Route::Instance()
    ->post('/admin/calendars-save', \App\controller\backend\CalendarsController::class,'calendars_save')
    ->name('admin.calendars.save');
/**
 * End: Routes for manage calendars
 */

/**
 * Routes for manage incentives
 */
\App\core\Route::Instance()
    ->get('/admin/incentives-index', \App\controller\backend\IncentivesController::class,'incentives_index')
    ->name('admin.incentives.index');
\App\core\Route::Instance()
    ->get('/admin/incentive-edit', \App\controller\backend\IncentivesController::class,'incentive_edit')
    ->name('admin.incentive.edit');
\App\core\Route::Instance()
    ->get('/admin/incentive-delete', \App\controller\backend\IncentivesController::class,'incentive_delete')
    ->name('admin.incentive.delete');
\App\core\Route::Instance()
    ->get('/admin/incentive-new', \App\controller\backend\IncentivesController::class,'incentive_new')
    ->name('admin.incentive.new');
\App\core\Route::Instance()
    ->post('/admin/incentive-save', \App\controller\backend\IncentivesController::class,'incentive_save')
    ->name('admin.incentive.save');
/**
 * End: Routes for manage incentives
 */

/**
 * Routes for manage FAQ
 */
\App\core\Route::Instance()
    ->get('/admin/faq-index', \App\controller\backend\FaqController::class,'faq_index')
    ->name('admin.faq.index');
\App\core\Route::Instance()
    ->get('/admin/faq-edit', \App\controller\backend\FaqController::class,'faq_edit')
    ->name('admin.faq.edit');
\App\core\Route::Instance()
    ->get('/admin/faq-delete', \App\controller\backend\FaqController::class,'faq_delete')
    ->name('admin.faq.delete');
\App\core\Route::Instance()
    ->get('/admin/faq-new', \App\controller\backend\FaqController::class,'faq_new')
    ->name('admin.faq.new');
\App\core\Route::Instance()
    ->post('/admin/faq-save', \App\controller\backend\FaqController::class,'faq_save')
    ->name('admin.faq.save');
/**
 * End: Routes for manage incentives
 */

// DSM users
\App\core\Route::Instance()
    ->get('/admin/region-staff', \App\controller\backend\UsersController::class,'region_staff')
    ->name('admin.region.staff');
\App\core\Route::Instance()
    ->get('/admin/region-staff-new', \App\controller\backend\UsersController::class,'region_staff_new')
    ->name('admin.region.staff.new');
\App\core\Route::Instance()
    ->get('/admin/region-staff-edit', \App\controller\backend\UsersController::class,'region_staff_edit')
    ->name('admin.region.staff.edit');
\App\core\Route::Instance()
    ->get('/admin/region-staff-delete', \App\controller\backend\UsersController::class,'region_staff_delete')
    ->name('admin.region.staff.delete');
\App\core\Route::Instance()
    ->post('/admin/region-staff-save', \App\controller\backend\UsersController::class,'region_staff_save')
    ->name('admin.region.staff.save');

\App\core\Route::Instance()
    ->get('/api/users-search', \App\controller\backend\ApiController::class,'users_search')
    ->name('api.users.search');
// DSM users end

// Super user for Su and Val
\App\core\Route::Instance()
    ->get('/admin/users-super', \App\controller\backend\UsersController::class,'super_users')
    ->name('admin.users.super');
\App\core\Route::Instance()
    ->get('/admin/users-super-new', \App\controller\backend\UsersController::class,'super_user_new')
    ->name('admin.users.super.new');
\App\core\Route::Instance()
    ->get('/admin/users-super-edit', \App\controller\backend\UsersController::class,'super_user_edit')
    ->name('admin.users.super.edit');
\App\core\Route::Instance()
    ->get('/admin/users-export', \App\controller\backend\UsersController::class,'users_export')
    ->name('admin.users.export');
\App\core\Route::Instance()
    ->get('/admin/users-super-delete', \App\controller\backend\UsersController::class,'super_user_delete')
    ->name('admin.users.super.delete');
\App\core\Route::Instance()
    ->post('/admin/users-super-save', \App\controller\backend\UsersController::class,'super_user_save')
    ->name('admin.users.super.save');
// Super user for Su and Val: End

\App\core\Route::Instance()
    ->get('/api/admin/load-nissan-dealers', \App\controller\backend\ApiController::class,'load_nissan_dealers')
    ->name('api.dealers.load');

\App\core\Route::Instance()
    ->get('/api/dsm/download-active-member-list', \App\controller\backend\ApiController::class,'download_active_member_list')
    ->name('api.dsm.download.active.member.list');

\App\core\Route::Instance()
    ->get('/api/dsm/download-regional-data', \App\controller\backend\ApiController::class,'download_regional_data')
    ->name('api.dsm.download.regional.data');

\App\core\Route::Instance()
    ->get('/api/dsm/load-regional-data', \App\controller\backend\ApiController::class,'load_regional_data')
    ->name('api.dsm.load.regional.data');

\App\core\Route::Instance()
    ->get('/admin/fake-user', \App\controller\backend\AdminController::class,'fake_user')
    ->name('admin.fake.user');

\App\core\Route::Instance()
    ->get('/manager/fake-user/dashboard', \App\controller\backend\AdminController::class,'fake_user')
    ->name('manager.fake.user.dashboard');
\App\core\Route::Instance()
    ->get('/manager/fake-user/matrics', \App\controller\backend\AdminController::class,'fake_user_matrics')
    ->name('manager.fake.user.matrics');

\App\core\Route::Instance()
    ->get('/admin/fake-region-staff', \App\controller\backend\AdminController::class,'fake_region_staff')
    ->name('admin.fake.region.staff');

\App\core\Route::Instance()
    ->get('/api/get-menus', \App\controller\backend\ApiController::class,'get_menus')
    ->name('api.get.menu');
/**
 * This is a must do action: dispatch at last
 */
\App\core\Route::Instance()->dispatch();
exit;