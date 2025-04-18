<?php

namespace App\Http\Controllers;

use App\Helper\{Defination, Role};
use App\Models\{Position, Ranking};
use App\Services\RankingService;
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
        $this->dataForView['menuName'] = Defination::PAGE_RANKING;
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

        $modalTitle = 'YTD ';
        $positions = $role === Role::TECHNICIAN ? [Role::MASTER_TECHNICIAN, Role::ADVANCED_TECHNICIAN] : [$role];
        $thisPeriod = Ranking::getMaxPeriodByPositionAndCat($positions);
        if (!$thisPeriod) {
            $thisPeriod = date('Y-m').'-01';
        }
        if($action == Ranking::PREVIOUS){
            // 表示从查询到的 $thisPeriod 的上个月1号开始计算
            $thisPeriod->subMonth(1);
        }
        $modalTitle .= $thisPeriod->format('F Y');
        $modalTitle .= ' - ' . ($role === Role::TECHNICIAN ? 'national ' : '') . $awardType;
        $tableTitle = Position::where('code', $role)->first()->title;
        $result = $role === Role::TECHNICIAN ?
            $this->service->getNationalRankings($positions, $thisPeriod->format('Y-m-d')) : 
            $this->service->get_ranking($positions, $awardType, $thisPeriod->format('Y-m-d'));

        if($result && count($result) > 0){
            return $this->success([
                'blocks'=>array_values($result),
                'modalTitle'=>$modalTitle,
                'tableTitle' => $tableTitle
            ]);
        }else{
            return $this->error();
        }
    }
}
