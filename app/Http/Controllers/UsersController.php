<?php

namespace App\Http\Controllers;

use App\Helper\{Defination, Role};
use App\Mail\{PasswordEnquiry, ResetPassword};
use App\Models\{Dealer, User};
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller {

    /** @var UserService  */
    private $service;

    /**
     * Create a new controller instance.
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService, Request $request) {
        parent::__construct($request);
        $this->service = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function my_team(Request $request) {
        $this->dataForView['menuName'] = Defination::PAGE_MY_TEAM;
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $this->dataForView['teamMembers'] = $this->service->getTeamMembersByRole($currentUser->dealer_code, $currentUser->position_code, $request->input());
        return $this->render('pages.my_team');
    }


    /**
     * @param Request $request
     */
    public function reset_password(Request $request){
        $email = $request->input('email');

        if($email && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = User::where('email', '=', $email)->firstOrFail();

            if($user){
                try {
                    Mail::to($user->email)->send(new ResetPassword($user->firstname));
                    Mail::to(config('elite.SUPPORT_EMAIL_ADDRESS'))->send(new PasswordEnquiry($user->email, $user->firstname));
                    return $this->success();
		} catch (\Exception $exception) {
                    $emailSent = false;
                    return $this->error($exception->getMessage());
                }
            }else{
                return $this->error('email not found');
            }
        }else{
            return $this->error('email not valid');
        }
    }

    /**
     * @param Request $request
     */
    public function user_search(Request $request) {
        $usersData = $this->service->searchUser(trim($request->query('q')));
        if($usersData && $usersData->count() > 0){
            return $this->success($usersData);
        }else{
            return $this->error();
        }
    }

    /**
     * entry point
     *
     */
    public function dealers_users() {
        $this->dataForView['users'] = $this->service->load();
        return $this->render('pages.backend.users_manager.users');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function user_info(User $user) {
        $this->dataForView['user'] = $user;
        return $this->render('pages.backend.users_manager.user_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function user_edit(Request $request) {
        $result = $this->service->update($request->input());
        if(gettype($result) === 'string') {
            return redirect()->back()->withErrors($result);
        }
        return redirect()->back();
    }

    /**
     * entry point
     *
     */
    public function region_staff() {
        $this->dataForView['region_staff'] = $this->service->loadRegionStaff();
        return $this->render('pages.backend.users_manager.region_staff');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function region_staff_info(User $user) {
        $this->dataForView['user'] = $user;
        $this->dataForView['positions'] = $this->service->getRegionStaffPositions();
        $this->dataForView['regions'] = $this->service->getRegions();
        return $this->render('pages.backend.users_manager.region_staff_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function region_staff_edit(Request $request) {
        $result = $this->service->updateRegionStaff($request->input());
        if(gettype($result) === 'string') {
            return redirect()->back()->withErrors($result);
        }
        return redirect()->back();

    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function region_staff_delete(User $user) {
        $this->service->delete($user);
        return redirect()->back();

    }

    /**
     * entry point
     *
     */
    public function admin_users() {
        $this->dataForView['admin_users'] = $this->service->loadAdminUsers();
        return $this->render('pages.backend.users_manager.admin_users');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function admin_user_info(User $user) {
        $this->dataForView['user'] = $user;
        return $this->render('pages.backend.users_manager.admin_user_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_user_edit(Request $request) {
        $result = $this->service->updateAdminUser($request->input());
        if(gettype($result) === 'string') {
            return redirect()->back()->withErrors($result);
        }
        return redirect()->back();

    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function admin_user_delete(User $user) {
        $this->service->delete($user);
        return redirect()->back();

    }

    /**
     * Jump to dealer site from regional staff dashboard
     * @return mixed
     */
    public function region_jump_to_dealer(){
        /** @var User $currentUser */
        $currentUser = Auth::user();
        Auth::logout();
        //$this->render('user/dealership_coming_soon');
        return redirect( config('dealership.dealExcellenceOverviewUrl') .'admin/mock/'. md5(rand()). '/'. base64_encode($currentUser->email));
    }

    /**
     * Jump to dealer site from tiles page
     * @return mixed
     */
    public function jump_to_dealer(){
        /** @var User $currentUser */
        $currentUser = Auth::user();
        if ($currentUser->position_code === Role::SALES_MANAGER) {
            return redirect( config('dealership.dealExcellenceOverviewUrl') .'api?role='. $currentUser->position_code . '&code='. $currentUser->dealer_code);
        } else {
            return redirect( config('dealership.dealExcellenceOverviewUrl') .'api?role=AP');
        }
    }

    /**
     * Manager (Sales manager etc.) use this function to mock team member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mock(Request $request, User $user) {

        $parameter = $request->input();
        $redirect = isset($parameter['directTo']) ? $parameter['directTo'] : 'dashboard';
        // mark as mock
        session(['mock' => true, 'mock-user' => $user]);

        return redirect()->route($redirect, ['user' => $user]);
    }

    /**
     * Admin user use this function to mock region staff
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function region_staff_mock(Request $request, User $user) {

        $parameter = $request->input();
        $redirect = isset($parameter['directTo']) ? $parameter['directTo'] : 'dashboard';

        Auth::login($user, false);
        session(['selected_position' => null]);
        return redirect()->route($redirect);
    }

    /**
     * Admin user use this function to mock member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function member_mock(Request $request, User $user) {

        $parameter = $request->input();
        $redirect = isset($parameter['directTo']) ? $parameter['directTo'] : 'dashboard';

        Auth::login($user, false);
        session(['selected_position' => null]);
        return redirect()->route($redirect);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    // should replace by region_staff_mock when fy22 dealer ship site set up
    public function fake_region_staff(Request $request){
        $userId = $request->input('uid');
        $decodeUid = filter_var(base64_decode($userId), FILTER_VALIDATE_EMAIL);
        /**
         * 1. from elite dealer - with email base64_encode()
         */
        if($decodeUid) {
            $user = User::where('email', '=', $decodeUid)->first();
        } else {
            $user = User::find($userId);
        }

        if ($user == null || $user->position_code == 'SYSTEM ADMIN') { return redirect('/login');}
        Auth::login($user, false);
        return redirect()->route('dashboard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function fake_dealer_team(Request $request){
        $dealerCode = $request->input('code');

        $this->dataForView['fromApi'] = true;
        /** @var Dealer $dealer */
        $dealer = Dealer::where('code', '=', $dealerCode)->firstOrFail();
        $this->dataForView['dealer'] = $dealer;
        if ($dealer){
            $user = $dealer->getDp();
            Auth::login($user, false);
            session(['fake_dealer' => true]);
            $this->dataForView['teamMembers'] = $this->service->getTeamMembersByDealerCode($dealerCode);
            return $this->render('pages.my_team');
        }
    }

    public function view_last_year(Request $request, User $user) {

        $parameter = $request->input();
        $user = User::Where('employee_code', '=', $parameter['code'])->first();
        $redirect = isset($parameter['directTo']) ? $parameter['directTo'] : 'dashboard';

        Auth::login($user, false);
        session(['selected_position' => null]);
        session(['view_last_year' => true]);
        return redirect()->route($redirect);
    }

    public function back_to_current_year(Request $request) {

        session(['view_last_year' => false]);
        echo("<script>window.close();</script>");
    }
}
