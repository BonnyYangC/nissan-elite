<?php

namespace App\Http\Controllers;

use App\Services\PagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller {

    /** @var PagesService  */
    private $pagesService;

    /**
     * Create a new controller instance.
     * @param PagesService $pagesService
     * @return void
     */
    public function __construct(PagesService $pagesService, Request $request) {
        parent::__construct($request);
        $this->pagesService = $pagesService;
    }

    /**
     * entry point
     *
     */
    public function dashboard() {
        $currentUser = Auth::user();
        $this->dataForView['menuName'] = 'dashboard';
        $this->dataForView['currentUser'] = $currentUser;
        if ($currentUser->position_code === 'ADMIN') {
            $this->dataForView['userRole'] = 'region_staff';
            return $this->regionStaffDashboard();
        } else {
            $this->dataForView['userRole'] = 'dealer_user';
            return $this->userDashboard();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    private function userDashboard() {
        //monthly points chart
        $this->dataForView['monthlyPoints'] = $this->pagesService->getMonthlyPointsData();

        /**
         * @var array $rankings
         * @var array $rankingsPlatinum
         */
        extract($this->pagesService->getLeadBoardData());
        //leader board table
        $this->dataForView['rankings'] = $rankings;
        $this->dataForView['rankingsPlatinum'] = $rankingsPlatinum;
        //current status level
        $ytd = $this->pagesService->getYearToDateData();
        $ytd = $ytd ? $ytd : '';
        $this->dataForView['status'] = (object)array_merge([
            'ytd' => $ytd
        ], $this->pagesService->getStatusData($ytd));
        // dollar rewards
        $this->dataForView['rewards'] = $this->pagesService->getRewardsData();
        // metrics
        $this->dataForView['metrics'] = $this->pagesService->getMetricsData(true);

        // current ranking status
        $this->dataForView['rankingStatus'] = $this->pagesService->getCurrentRanking();

        //year to date
        $this->dataForView['ytd'] = $ytd;

        //historical points
        $this->dataForView['historical'] = $this->pagesService->getHistoricalData();
        return $this->render('pages.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    private function regionStaffDashboard() {
        $this->dataForView['regions'] = $this->pagesService->getRegions();
        return $this->render('pages.territory_report');
    }

    /**
     * entry point
     *
     */
    public function metrics() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'metrics';
        //metrics
        $this->dataForView['metrics'] = $this->pagesService->getMetricsData();
/*var_dump($currentUser->results()->pluck('metrics', 'period'));
$this->dataForView['metricData'] = [
    'title' => '1. metrics test title',
    'chart_name' => 'metric-chart',
    'chart_data' => json_encode([['Month', 'Points'], ['Apr', 100], ['May', 100], ['Jun', 100], ['Jul', 100], ['Aug', 100], ['Sep', 100], ['Oct', 100], ['Nov', 100], ['Dec', 100]]),

    'table_data' => ['RESULT' => ['100','100','100','100','100','100','100','100','100','100','100','100']],
    'extra_class' => '',
    'ref' => 'test ref string',
    'guides' => [[
        'title' => 'MATCHED ORDER WRITE GUIDE',
        'top' => ['Sales Manager', '0 or 1 unit Variation', '2 unit Variation', '3 unit Variation'],
        'rows' => [['Category A', 310, 105, 105], ['Category B', 310, 105, 105], ['Category C', 310, 105, '']]
    ]]
];*/
        return $this->render('pages.metrics');
    }

    /**
     * entry point
     *
     */
    public function loyalty() {
        $this->dataForView['menuName'] = 'loyalty';
        //year to date
        $this->dataForView['ytd'] = $this->pagesService->getYearToDateData();

        //historical points
        $this->dataForView['historical'] = $this->pagesService->getHistoricalData();
        return $this->render('pages.loyalty');
    }

    /**
     * entry point
     *
     */
    public function incentives() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'incentives';

        $this->dataForView['current'] = $this->pagesService->getIncentives('current', 'All');
        $this->dataForView['finished'] = $this->pagesService->getIncentives('finished', 'All');
        $this->dataForView['past'] = $this->pagesService->getIncentives('past', 'All');
        return $this->render('pages.incentives');
    }

    /**
     * entry point
     *
     */
    public function member_guide() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'member_guide';
        return $this->render('pages.member_guide');
    }

    /**
     * entry point
     *
     */
    public function program() {
        $this->dataForView['menuName'] = 'program';
        return $this->render('pages.program');
    }

    /**
     * entry point
     *
     */
    public function calendar() {
        $this->dataForView['menuName'] = 'calendar';
        $obj1 = [
            'id' => '30',
            'name' => 'LEAF i_ELITE BONUS POINTS',
            'startDate' => strtotime('2020-07-01'),
            'endDate' => strtotime('2020-09-30'),
        ];
        $this->dataForView['nissanEvents'] = json_encode([$obj1]);

        return $this->render('pages.calendar');
    }

    /**
     * entry point
     *
     */
    public function product_challenge() {
        $this->dataForView['menuName'] = 'product_challenge';
        return $this->render('pages.product_challenge');
    }

    /**
     * entry point
     *
     */
    public function awards() {
        $this->dataForView['menuName'] = 'awards';
        return $this->render('pages.awards');
    }

    /**
     * entry point
     *
     */
    public function account() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'account';
        return $this->render('pages.account');
    }

    /**
     * entry point
     *
     */
    public function faq() {
        $this->dataForView['menuName'] = 'faq';
        $this->dataForView['faqs'] = $this->pagesService->getFaqs();
        return $this->render('pages.faq');
    }
}
