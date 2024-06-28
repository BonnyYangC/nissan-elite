<?php

namespace App\Services\ExportServices;

use App\Helper\Role;
use App\Helper\Utility;
use App\Models\Ranking as RankingModel;
use App\Services\BaseService;
use App\Services\ServiceResolver;
use Carbon\Carbon;

class Ranking extends BaseService {
    private $parameters;

    /**
     * Create a new service instance.
     *
     * @param ServiceResolver $serviceResolver
     * @param $parameters
     */
    public function __construct(ServiceResolver $serviceResolver, $parameters) {
        parent::__construct($serviceResolver);
        $this->parameters = $parameters;
    }

    /**
     *
     */
    public function export() {

        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $role = $this->parameters['role'];
        $action = $this->parameters['action'];
        $awardType = $this->parameters['type'] ? $this->parameters['type'] : RankingModel::AWARD_STATUS;
        $positions = $role === Role::TECHNICIAN ? [Role::MASTER_TECHNICIAN, Role::ADVANCED_TECHNICIAN] : [$role];

        $thisPeriod = RankingModel::getMaxPeriodByPositionAndCat($positions);
        if (!$thisPeriod) {
            $thisPeriod = date('Y-m').'-01';
        }
        if($action == RankingModel::PREVIOUS){
            // 表示从查询到的 $thisPeriod 的上个月1号开始计算
            $thisPeriod->subMonth(1);
        }
        if($role === Role::TECHNICIAN) {
            $result = RankingModel::getNationalRankingsBy($positions, $thisPeriod->format('Y-m-d'))->all();
        } else {
            $result = RankingModel::getRankingsBy($positions, $thisPeriod->format('Y-m-d'), $awardType)->all();
        }

        $contentMap = [
            'Rank' => 'rank',
            'First Name' => 'firstname',
            'Last Name' => 'lastname',
            'Dealer' => 'name',
            'Category' => 'category',
            'State' => 'state', // if is national ranking, then use dealer state, otherwise use rank state
            $awardType == RankingModel::AWARD_STATUS ? 'Points' : 'Points Platinum' => 'total',
            'Registered' => 'registered',
        ];

        return Utility::exportToFile($awardType.'rankings_'.$today->format('d_M_Y').'.csv', $result, $contentMap);
    }

}
