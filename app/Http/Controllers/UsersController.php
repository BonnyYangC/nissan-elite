<?php

namespace App\Http\Controllers;

use App\Helper\JsonBuilder;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->dataForView['menuName'] = 'my_team';
        $currentUser = Auth::user();
        $this->dataForView['teamMembers'] = $this->service->getTeamMembersByRole($currentUser->dealer_code, $currentUser->position_code, $request->input());
        return $this->render('pages.my_team');
    }

    /**
     * @param Request $request
     */
    public function user_search(Request $request) {
        $usersData = $this->service->searchUser(trim($request->query('q')));
        if($usersData && $usersData->count() > 0){
            echo JsonBuilder::Success($usersData);
        }else{
            echo JsonBuilder::Error();
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
        $this->service->update($request->input());
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
        $this->service->updateRegionStaff($request->input());
        return redirect()->back();

    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
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
        $this->service->updateAdminUser($request->input());
        return redirect()->back();

    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_user_delete(User $user) {
        $this->service->delete($user);
        return redirect()->back();

    }

    /**
     * Jump to dealer site from regional staff dashboard
     * @return mixed
     */
    public function jump_to_dealer(){
        /** @var User $currentUser */
        $currentUser = Auth::user();
        Auth::logout();
        //$this->render('user/dealership_coming_soon');
        return redirect( env('dealExcellenceOverviewUrl') .'admin/mock/'. md5(rand()). '/'. base64_encode($currentUser->email));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mock(Request $request, User $user) {
        $parameter = $request->input();
        $redirect = isset($parameter['directTo']) ? $parameter['directTo'] : 'dashboard';
        //Auth::logout();
        Auth::login($user, true);
        return redirect()->route($redirect);
    }
}
