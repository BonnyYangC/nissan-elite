<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use App\Models\Ranking as RankingModel;
use App\Services\BaseService;
use App\Services\ServiceResolver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $position = $this->parameters['role'];
        $action = $this->parameters['action'];
        $awardType = $this->parameters['type'] ? $this->parameters['type'] : RankingModel::AWARD_STATUS;

        $thisPeriod = RankingModel::getMaxPeriodByPositionAndCat($position);
        if (!$thisPeriod) {
            $thisPeriod = date('Y-m').'-01';
        }
        if($action == RankingModel::PREVIOUS){
            // 表示从查询到的 $thisPeriod 的上个月1号开始计算
            $thisPeriod->subMonth(1);
        }

        $result = RankingModel::getRankingsBy($position, $thisPeriod, $awardType)->all();
        //$result = $this->serviceResolver->rankingService()->get_ranking($position, $awardType, $thisPeriod);

        $contentMap = [
            'Rank' => 'rank',
            'First Name' => 'firstname',
            'Last Name' => 'lastname',
            'Dealer' => 'name',
            'Category' => 'category',
            'State' => 'rank_state',
            $awardType == RankingModel::AWARD_STATUS ? 'Points' : 'Points Platinum' => 'total',
            'Registered' => 'registered',
        ];

        return Utility::exportToFile($awardType.'rankings_'.$today->format('d_M_Y').'.csv', $result, $contentMap);
    }

}
