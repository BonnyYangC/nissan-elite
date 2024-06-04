<?php

namespace App\Http\Controllers;

use App\Models\{Position};
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    private $service;

    public function __construct(DashboardService $dashboardService, Request $request) {
        parent::__construct($request);
        $this->service = $dashboardService;
    }

    public function dashboard() {
        $this->dataForView['menuName'] = 'dashboard';
        $currentUser = $this->dataForView['currentUser'];
        if ($currentUser->position_code === 'ADMIN' || in_array($currentUser->position_code, Position::REGION_STAFF_POSITIONS)) {
            $this->dataForView['userRole'] = 'region_staff';
            return $this->regionStaffDashboard();
        } else {
            $this->dataForView['userRole'] = 'dealer_user';
            return $this->userDashboard();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ImagickException
     */
    private function userDashboard() {
        $selectedPosition = $this->dataForView['selectedPosition']->get('code');

        $this->dataForView = array_merge(
            $this->dataForView, 
            $this->service->buildMemberDashboardData($selectedPosition)
        );
        return $this->render('pages.dashboard');
    }

    private function regionStaffDashboard() {
        $this->dataForView['regions'] = $this->service->getRegions();
        return $this->render('pages.territory_report');
    }

}
