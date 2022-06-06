<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome'); });
Route::get('login',[App\Http\Controllers\LoginController::class, 'index']);
Route::post('login',[App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

//dealer users
Route::group(['middleware' => ['auth']],function () {
    Route::get('/elite_individual', [App\Http\Controllers\HomeController::class, 'index'])->name('elite_individual');

//pages
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/metrics', [App\Http\Controllers\MetricsController::class, 'metrics'])->name('metrics');
    Route::get('/my_team', [App\Http\Controllers\UsersController::class, 'my_team'])->name('my_team');
    Route::get('/ranking', [App\Http\Controllers\RankingsController::class, 'ranking'])->name('ranking');
    Route::get('/get_ranking', [App\Http\Controllers\RankingsController::class, 'get_ranking'])->name('get_ranking');
    Route::get('/incentives', [App\Http\Controllers\PagesController::class, 'incentives'])->name('incentives');
    Route::get('/member_guide', [App\Http\Controllers\PagesController::class, 'member_guide'])->name('member_guide');
    Route::get('/future_sales', [App\Http\Controllers\FutureSalesController::class, 'future_sales'])->name('future_sales');
    Route::get('/future_sales/explanation', [App\Http\Controllers\FutureSalesController::class, 'future_sales_explanation'])->name('future_sales.explanation');
    Route::get('/future_sales/contact_schedule', [App\Http\Controllers\FutureSalesController::class, 'future_sales_contact_schedule'])->name('future_sales.contact_schedule');
    Route::get('/future_sales/postcard', [App\Http\Controllers\FutureSalesController::class, 'future_sales_postcard'])->name('future_sales.postcard');
    Route::get('/program', [App\Http\Controllers\PagesController::class, 'program'])->name('program');
    Route::get('/calendar', [App\Http\Controllers\PagesController::class, 'calendar'])->name('calendar');
    Route::get('/product_challenge', [App\Http\Controllers\PagesController::class, 'product_challenge'])->name('product_challenge');
    Route::get('/awards', [App\Http\Controllers\PagesController::class, 'awards'])->name('awards');
    Route::get('/loyalty', [App\Http\Controllers\PagesController::class, 'loyalty'])->name('loyalty');
    Route::get('/guild', [App\Http\Controllers\GuildController::class, 'guild'])->name('guild');
    Route::get('/guild/events', [App\Http\Controllers\GuildController::class, 'guild_events'])->name('guild.events');
    Route::get('/guild/members', [App\Http\Controllers\GuildController::class, 'guild_members'])->name('guild.members');
    Route::get('/account', [App\Http\Controllers\PagesController::class, 'account'])->name('account');
    Route::get('/faq', [App\Http\Controllers\PagesController::class, 'faq'])->name('faq');

    Route::get('/dashboard/current-status-level', [App\Http\Controllers\GageController::class, 'current_status_level'])->name('current_status_level');
    Route::get('/dashboard/loyalty-status-level', [App\Http\Controllers\GageController::class, 'loyalty_status_level'])->name('loyalty_status_level');

    Route::get('/jump_to_dealer', [App\Http\Controllers\UsersController::class, 'jump_to_dealer'])->name('jump_to_dealer');
});

//region staff only
Route::group(['prefix' => 'region', 'middleware' => ['auth']],function (){
    Route::get('/load_report', [App\Http\Controllers\RegionController::class, 'load_report'])->name('region.load_report');

    Route::get('/jump_to_dealer', [App\Http\Controllers\UsersController::class, 'region_jump_to_dealer'])->name('region.jump_to_dealer');
});

//backend, admin only
Route::group(['prefix' => 'admin', 'middleware' => ['auth']],function (){
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/data_process', [App\Http\Controllers\AdminController::class, 'data_process'])->name('admin.data_process');
    Route::get('/data_export/{type}', [App\Http\Controllers\AdminController::class, 'data_export'])->name('admin.data_export');

    Route::get('/users/search', [App\Http\Controllers\UsersController::class, 'user_search'])->name('admin.users.search');
    Route::get('/users/mock/{user}', [App\Http\Controllers\UsersController::class, 'mock'])->name('admin.users.mock');

    Route::get('/dealers_users', [App\Http\Controllers\UsersController::class, 'dealers_users'])->name('admin.dealers_users');
    Route::get('/users/{user}', [App\Http\Controllers\UsersController::class, 'user_info'])->name('admin.user.info');
    Route::post('/user/edit', [App\Http\Controllers\UsersController::class, 'user_edit'])->name('admin.user.edit');

    Route::get('/region_staff', [App\Http\Controllers\UsersController::class, 'region_staff'])->name('admin.region_staff');
    Route::get('/region_staff/{user}', [App\Http\Controllers\UsersController::class, 'region_staff_info'])->name('admin.region_staff.info');
    Route::post('/region_staff/edit', [App\Http\Controllers\UsersController::class, 'region_staff_edit'])->name('admin.region_staff.edit');
    Route::get('/region_staff/mock/{user}', [App\Http\Controllers\UsersController::class, 'region_staff_mock'])->name('admin.region_staff.mock');
    Route::get('/region_staff/delete/{user}', [App\Http\Controllers\UsersController::class, 'region_staff_delete'])->name('admin.region_staff.delete');

    Route::get('/admin_users', [App\Http\Controllers\UsersController::class, 'admin_users'])->name('admin.admin_users');
    Route::get('/admin_users/info/{user?}', [App\Http\Controllers\UsersController::class, 'admin_user_info'])->name('admin.admin_user.info');
    Route::post('/admin_user/edit', [App\Http\Controllers\UsersController::class, 'admin_user_edit'])->name('admin.admin_user.edit');
    Route::get('/admin_user/delete/{user}', [App\Http\Controllers\UsersController::class, 'admin_user_delete'])->name('admin.admin_user.delete');
    Route::post('/admin_user/new', [App\Http\Controllers\UsersController::class, 'admin_user_new'])->name('admin.admin_user.new');

    Route::get('/usage', [App\Http\Controllers\AdminController::class, 'usage'])->name('admin.usage');
    Route::get('/historical_export', [App\Http\Controllers\AdminController::class, 'historical_export'])->name('admin.historical_export');

    Route::get('/calendars', [App\Http\Controllers\EventController::class, 'calendars'])->name('admin.calendars');
    Route::get('/events/info/{event?}', [App\Http\Controllers\EventController::class, 'event_info'])->name('admin.event.info');
    Route::post('/event/edit', [App\Http\Controllers\EventController::class, 'event_edit'])->name('admin.event.edit');
    Route::get('/events/delete/{event}', [App\Http\Controllers\EventController::class, 'event_delete'])->name('admin.event.delete');

    Route::get('/incentives', [App\Http\Controllers\IncentiveController::class, 'incentives'])->name('admin.incentives');
    Route::get('/incentives/info/{incentive?}', [App\Http\Controllers\IncentiveController::class, 'incentive_info'])->name('admin.incentive.info');
    Route::post('/incentive/edit', [App\Http\Controllers\IncentiveController::class, 'incentive_edit'])->name('admin.incentive.edit');
    Route::get('/incentives/delete/{incentive}', [App\Http\Controllers\IncentiveController::class, 'incentive_delete'])->name('admin.incentive.delete');

    Route::get('/faqs', [App\Http\Controllers\FaqController::class, 'faqs'])->name('admin.faqs');
    Route::get('/faqs/info/{faq?}', [App\Http\Controllers\FaqController::class, 'faq_info'])->name('admin.faq.info');
    Route::post('/faq/edit', [App\Http\Controllers\FaqController::class, 'faq_edit'])->name('admin.faq.edit');
    Route::get('/faqs/delete/{faq}', [App\Http\Controllers\FaqController::class, 'faq_delete'])->name('admin.faq.delete');

    Route::post('/system_config', [App\Http\Controllers\AdminController::class, 'system_config'])->name('admin.system_config');
});
