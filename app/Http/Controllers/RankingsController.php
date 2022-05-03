<?php

namespace App\Http\Controllers;

use App\Helper\JsonBuilder;
use App\Models\Ranking;
use App\Services\RankingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RankingsController extends Controller {

    /** @var RankingService  */
    private $service;

    /**
     * Create a new controller instance.
     * @param RankingService $rankingService
     * @param Request $request
     * @return void
     */
    public function __construct(RankingService $rankingService, Request $request) {
        parent::__construct($request);
        $this->service = $rankingService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function ranking() {
        $this->dataForView['menuName'] = 'ranking';
        //for Sales Manager, Retail Sales Consultant and Fleet Sales Executive
        $this->dataForView['rankingForAll'] = [
            Ranking::CURRENT,
            Ranking::PREVIOUS
        ];
        //for All other roles
        $this->dataForView['rankingForNationalOnly'] = [
            Ranking::CURRENT.' '.Ranking::NATIONAL,
            Ranking::PREVIOUS.' '.Ranking::NATIONAL
        ];

        $this->dataForView['userGroups1'] = $this->service->getUsersGroupsArray1();
        $this->dataForView['userGroups2'] = $this->service->getUsersGroupsArray2();
        $this->dataForView['userGroups3'] = $this->service->getUsersGroupsArray3();
//var_dump($this->dataForView['userGroups1']);
        $this->dataForView['awardType'] = [Ranking::AWARD_STATUS, Ranking::AWARD_PLATINUM];
        return $this->render('pages.ranking');
    }

    /**
     * @param Request $request
     */
    public function get_ranking(Request $request) {

        $role = $request->input('role');
        $action = $request->input('action');
        $awardType = $request->input('type') ? $request->input('type') : Ranking::AWARD_STATUS;
        /*
         * 'role' => string 'M' (length=1)
  'action' => string 'Current' (length=7)
  'type' => string 'status' (length=6)
         * */

        $modalTitle = 'YTD ';
        $thisPeriod = Ranking::getMaxPeriodByPositionAndCat($role);
        if (!$thisPeriod) {
            $thisPeriod = date('Y-m').'-01';
        }
        //$thisPeriod = Carbon::createFromFormat('Y-m-d', $thisPeriod);
        if($action == Ranking::PREVIOUS){
            // 表示从查询到的 $thisPeriod 的上个月1号开始计算
            $thisPeriod->subMonth(1);
        }
        $modalTitle .= Carbon::createFromFormat('Y-m-d', $thisPeriod)->format('F Y');
        $modalTitle .= ' - '.$awardType;

        $result = $this->service->get_ranking($role, $awardType, $thisPeriod);

        if($result && count($result) > 0){
            echo JsonBuilder::Success([
                'blocks'=>array_values($result),
                'modalTitle'=>$modalTitle
            ]);
        }else{
            echo JsonBuilder::Error();
        }
    }
}
