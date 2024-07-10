<?php

use App\Http\Controllers\FaqController;
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

Route::get('/admin/fake-region-staff', [App\Http\Controllers\UsersController::class,'fake_region_staff'])->name('admin.fake.region.staff');  //TBD, replace with admin.region_staff.mock

Route::get('/reset_password', [App\Http\Controllers\UsersController::class,'reset_password'])->name('reset_password');

//dealer users
Route::group(['middleware' => 'auth'],function () {
    Route::get('/elite_individual', [App\Http\Controllers\HomeController::class, 'index'])->name('elite_individual');

//pages
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/metrics', [App\Http\Controllers\MetricsController::class, 'metrics'])->name('metrics');
    Route::get('/my_team', [App\Http\Controllers\UsersController::class, 'my_team'])->name('my_team');
    Route::get('/ranking', [App\Http\Controllers\RankingsController::class, 'ranking'])->name('ranking');
    Route::get('/get_ranking', [App\Http\Controllers\RankingsController::class, 'get_ranking'])->name('get_ranking');
    Route::get('/incentives', [App\Http\Controllers\IncentiveController::class, 'index'])->name('incentives');
    Route::get('/news', [App\Http\Controllers\NewsController::class, 'news'])->name('news');
    Route::get('/member_guide', App\Http\Controllers\MemberGuideController::class)->name('member_guide');
    Route::get('/member_guide/pdf', [App\Http\Controllers\MemberGuideController::class, 'pdf'])->name('member_guide.pdf');
    Route::get('/future_sales', [App\Http\Controllers\FutureSalesController::class, 'future_sales'])->name('future_sales');
    Route::get('/future_sales/explanation', [App\Http\Controllers\FutureSalesController::class, 'future_sales_explanation'])->name('future_sales.explanation');
    Route::get('/future_sales/contact_schedule', [App\Http\Controllers\FutureSalesController::class, 'future_sales_contact_schedule'])->name('future_sales.contact_schedule');
    Route::get('/future_sales/postcard', [App\Http\Controllers\FutureSalesController::class, 'future_sales_postcard'])->name('future_sales.postcard');
    Route::get('/program', App\Http\Controllers\ProgramController::class)->name('program');
    Route::get('/calendar', [App\Http\Controllers\EventController::class, 'calendar'])->name('calendar');
    Route::get('/product_challenge', App\Http\Controllers\ProductChallengeController::class)->name('product_challenge');
    Route::get('/awards', App\Http\Controllers\AwardsController::class)->name('awards');
    Route::get('/loyalty', [App\Http\Controllers\LoyaltyController::class, 'loyalty'])->name('loyalty');
    Route::get('/guild', [App\Http\Controllers\GuildController::class, 'guild'])->name('guild');
    Route::get('/guild/events', [App\Http\Controllers\GuildController::class, 'guild_events'])->name('guild.events');
    Route::get('/guild/members', [App\Http\Controllers\GuildController::class, 'guild_members'])->name('guild.members');
    Route::get('/account', App\Http\Controllers\AccountController::class)->name('account');
    Route::get('/help', [App\Http\Controllers\FaqController::class, 'published'])->name('help');

    //Route::get('/dashboard/current-status-level', [App\Http\Controllers\GageController::class, 'current_status_level3'])->name('current_status_level2');
    //Route::get('/dashboard/loyalty-status-level', [App\Http\Controllers\GageController::class, 'loyalty_status_level'])->name('loyalty_status_level');

    Route::get('/jump_to_dealer', [App\Http\Controllers\UsersController::class, 'jump_to_dealer'])->name('jump_to_dealer');
    Route::get('/users/mock/{user}', [App\Http\Controllers\UsersController::class, 'mock'])->name('users.mock');
});

//region staff only
Route::group(['prefix' => 'region', 'middleware' => 'auth'],function (){
    Route::get('/load_report', [App\Http\Controllers\RegionController::class, 'load_report'])->name('region.load_report');

    Route::get('/jump_to_dealer', [App\Http\Controllers\UsersController::class, 'region_jump_to_dealer'])->name('region.jump_to_dealer');
});

//backend, admin only
Route::group(['prefix' => 'admin', 'middleware' => 'auth'],function (){
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/data_process', [App\Http\Controllers\AdminController::class, 'data_process'])->name('admin.data_process');
    Route::get('/data_export/{type}', [App\Http\Controllers\AdminController::class, 'data_export'])->name('admin.data_export');

    Route::get('/users/search', [App\Http\Controllers\UsersController::class, 'user_search'])->name('admin.users.search');
    Route::get('/users/mock/{user}', [App\Http\Controllers\UsersController::class, 'member_mock'])->name('admin.users.mock');

    Route::get('/dealers_users', [App\Http\Controllers\UsersController::class, 'dealers_users'])->name('admin.dealers_users');
    Route::get('/users/{user}', [App\Http\Controllers\UsersController::class, 'user_info'])->name('admin.user.info');
    Route::post('/user/edit', [App\Http\Controllers\UsersController::class, 'user_edit'])->name('admin.user.edit');

    Route::get('/region_staff', [App\Http\Controllers\UsersController::class, 'region_staff'])->name('admin.region_staff');
    Route::get('/region_staff/info/{user?}', [App\Http\Controllers\UsersController::class, 'region_staff_info'])->name('admin.region_staff.info');
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

    Route::get('/calendars', [App\Http\Controllers\EventController::class, 'index'])->name('admin.calendars');
    Route::get('/events/info/{event?}', [App\Http\Controllers\EventController::class, 'event_info'])->name('admin.event.info');
    Route::post('/event/edit', [App\Http\Controllers\EventController::class, 'event_edit'])->name('admin.event.edit');
    Route::get('/events/delete/{event}', [App\Http\Controllers\EventController::class, 'event_delete'])->name('admin.event.delete');

    Route::get('/incentives', [App\Http\Controllers\IncentiveController::class, 'incentives'])->name('admin.incentives');
    Route::get('/incentives/info/{incentive?}', [App\Http\Controllers\IncentiveController::class, 'incentive_info'])->name('admin.incentive.info');
    Route::post('/incentive/edit', [App\Http\Controllers\IncentiveController::class, 'incentive_edit'])->name('admin.incentive.edit');
    Route::get('/incentives/delete/{incentive}', [App\Http\Controllers\IncentiveController::class, 'incentive_delete'])->name('admin.incentive.delete');

    Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('admin.news');
    Route::get('/news/info/{news?}', [App\Http\Controllers\NewsController::class, 'news_info'])->name('admin.news.info');
    Route::post('/news/edit', [App\Http\Controllers\NewsController::class, 'news_edit'])->name('admin.news.edit');
    Route::get('/news/delete/{news}', [App\Http\Controllers\NewsController::class, 'news_delete'])->name('admin.news.delete');

    Route::resource('faqs', FaqController::class);
    Route::post('/faq/edit', [App\Http\Controllers\FaqController::class, 'update'])->name('admin.faq.edit');
    Route::get('/faqs/delete/{faq}', [App\Http\Controllers\FaqController::class, 'destroy'])->name('faq.delete');

    Route::post('/system_config', [App\Http\Controllers\AdminController::class, 'system_config'])->name('admin.system_config');
});

//api only
Route::group(['prefix' => 'api', 'middleware' => 'auth'],function (){
    Route::get('/my-team', [App\Http\Controllers\UsersController::class,'fake_dealer_team'])->name('api.dealer_team');
    Route::get('/mock/user/{user}', [App\Http\Controllers\UsersController::class, 'mock'])->name('api.user.mock');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('api.dashboard');
    Route::get('/metrics', [App\Http\Controllers\MetricsController::class, 'metrics'])->name('api.metrics');
    Route::get('/view-last-year', [App\Http\Controllers\UsersController::class,'view_last_year'])->name('api.view_last_year');
    Route::get('/back-to-current-year', [App\Http\Controllers\UsersController::class,'back_to_current_year'])->name('api.back_to_current_year');
});
