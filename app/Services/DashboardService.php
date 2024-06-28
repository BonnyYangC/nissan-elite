<?php

namespace App\Services;

use App\Models\Position;
use App\Repositories\RegionRepository;
use App\Services\GageServices\Current;
use App\Services\GageServices\Techician;
use App\Services\ServiceResolver;

class DashboardService {

    /** @var RegionRepository */
    private $regionRepo;

    /** @var ServiceResolver  */
    private $resolver;

    public function __construct(ServiceResolver $resolver, RegionRepository $regionRepository) {
        $this->regionRepo = $regionRepository;
        $this->resolver = $resolver;
    }

    public function getRegions() {
        return $this->regionRepo->getTerritoryReportRegions();
    }

    public function buildMemberDashboardData(string $selectedPosition) {
        //year to date
        $ytd = $this->resolver->resultService()->getYearToDateData($selectedPosition);
        $ytd = $ytd ? $ytd : '';
        //current status level
        $statusChart = array_merge([
            'ytd' => $ytd
        ], $this->resolver->statusService()->buildStatusData($ytd));
        if(in_array($selectedPosition, Position::TECHNICIAN_POSITIONS)){
            $rankingOfCurrentUser = $this->resolver->rankingService()->getRankingOfCurrentUser($selectedPosition);
            (new Techician())->current_status_level($selectedPosition, $rankingOfCurrentUser->rank, $ytd, $statusChart);
        } else {
            (new Current())->current_status_level($ytd, $statusChart);
        }

        return array_merge([
            'monthlyPoints' => $this->resolver->resultService()->buildMonthlyData($selectedPosition),
            'rewards' => $this->resolver->rewardsService()->buildRewardsData($selectedPosition),
            'rankingStatus' => $this->resolver->rankingService()->getCurrentRanking($selectedPosition),
            'ytd' => $ytd,
            'status' => (object)$statusChart,
            'stackedMetrics' => $this->resolver->metricsService()->getStackedMetricsData($selectedPosition),
            'historical' => $this->resolver->historicalService()->getHistoricalData()
        ], $this->resolver->rankingService()->getRankingDataByPosition($selectedPosition));
    }
}
