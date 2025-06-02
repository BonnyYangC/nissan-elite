<?php

namespace App\Services;

use App\Models\Position;
use App\Repositories\RegionRepository;
use App\Services\GageServices\Current;
use App\Services\GageServices\Techician;
use App\Services\MetricsServices\StackedMetrics;
use App\Services\ServiceResolver;

class DashboardService {

    /** @var RegionRepository */
    private $regionRepo;

    /** @var ServiceResolver  */
    private $resolver;
    private $stackedMetricsService;

    public function __construct(ServiceResolver $resolver, StackedMetrics $stackedMetricsService, RegionRepository $regionRepository) {
        $this->regionRepo = $regionRepository;
        $this->resolver = $resolver;
        $this->stackedMetricsService = $stackedMetricsService;
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
            (new Techician())->current_status_level($selectedPosition, $rankingOfCurrentUser ? $rankingOfCurrentUser->rank : 0, $ytd, $statusChart);
        } else {
            (new Current())->current_status_level($ytd, $statusChart);
        }

        return array_merge([
            'monthlyPoints' => $this->resolver->resultService()->buildMonthlyData($selectedPosition),
            'rewards' => $this->resolver->rewardsService()->buildRewardsData($selectedPosition),
            'rankingStatus' => $this->resolver->rankingService()->getCurrentRanking($selectedPosition),
            'ytd' => $ytd,
            'status' => (object)$statusChart,
            'stackedMetrics' => $this->stackedMetricsService->get($selectedPosition),
            'historical' => $this->resolver->historicalService()->getHistoricalData()
        ], $this->resolver->rankingService()->getRankingDataByPosition($selectedPosition));
    }
}
