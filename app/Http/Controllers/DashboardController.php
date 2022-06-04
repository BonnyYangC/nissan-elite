<?php

namespace App\Http\Controllers;

use App\Models\{Position, User};
use App\Services\ServiceResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    /** @var ServiceResolver  */
    private $resolver;

    /**
     * DashboardController constructor.
     * @param ServiceResolver $resolver
     * @param Request $request
     */
    public function __construct(ServiceResolver $resolver, Request $request) {
        parent::__construct($request);
        $this->resolver = $resolver;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ImagickException
     */
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
        //monthly points chart
        $this->dataForView['monthlyPoints'] = $this->resolver->resultService()->buildResultsData();

        /**
         * @var array $rankings
         * @var array $rankingsPlatinum
         */
        extract($this->resolver->rankingService()->getLeadBoardData());
        //leader board table
        $this->dataForView['rankings'] = $rankings;
        $this->dataForView['rankingsPlatinum'] = $rankingsPlatinum;
        //current status level
        $ytd = $this->resolver->resultService()->getYearToDateData();
        $ytd = $ytd ? $ytd : '';
        $this->dataForView['status'] = (object)array_merge([
            'ytd' => $ytd
        ], $this->resolver->statusService()->buildStatusData($ytd));
        // dollar rewards
        $this->dataForView['rewards'] = $this->resolver->rewardsService()->buildRewardsData();

        // current ranking status
        $this->dataForView['rankingStatus'] = $this->resolver->rankingService()->getCurrentRanking();
        // current status level
        $this->resolver->gageService()->current_status_level();
        //year to date
        $this->dataForView['ytd'] = $ytd;

        // metrics
        $this->dataForView['stackedMetrics'] = $this->resolver->metricsService()->getStackedMetricsData();
        //historical points
        $this->dataForView['historical'] = $this->resolver->historicalService()->getHistoricalData();
        return $this->render('pages.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    private function regionStaffDashboard() {
        $this->dataForView['regions'] = $this->resolver->regionService()->getTerritoryReportRegions();
        return $this->render('pages.territory_report');
    }

}
