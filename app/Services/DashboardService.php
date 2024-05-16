<?php

namespace App\Services;

use App\Repositories\RegionRepository;
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
        /**
         * @var array $rankings
         * @var array $rankingsPlatinum
         */
        extract($this->resolver->rankingService()->getLeadBoardData($selectedPosition));

        //year to date
        $ytd = $this->resolver->resultService()->getYearToDateData($selectedPosition);
        $ytd = $ytd ? $ytd : '';
        //current status level
        $statusChart = array_merge([
            'ytd' => $ytd
        ], $this->resolver->statusService()->buildStatusData($ytd));
        $this->resolver->gageService()->current_status_level($ytd, $statusChart);

        return [
            'monthlyPoints' => $this->resolver->resultService()->buildMonthlyData($selectedPosition),
            'rankings' => $rankings,
            'rankingsPlatinum' => $rankingsPlatinum,
            'rewards' => $this->resolver->rewardsService()->buildRewardsData($selectedPosition),
            'rankingStatus' => $this->resolver->rankingService()->getCurrentRanking($selectedPosition),
            'ytd' => $ytd,
            'status' => (object)$statusChart,
            'stackedMetrics' => $this->resolver->metricsService()->getStackedMetricsData($selectedPosition),
            'historical' => $this->resolver->historicalService()->getHistoricalData()
        ];
    }
}
