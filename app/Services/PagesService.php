<?php

namespace App\Services;

use App\Models\Ranking;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;

class PagesService extends BaseService {

    /**
     * @return false|string
     */
    public function getMonthlyPointsData() {
        return $this->serviceResolver->resultService()->buildResultsData();
    }

    /**
     * @return false|string
     */
    public function getYearToDateData() {
        return $this->serviceResolver->resultService()->getYearToDateData();
    }

    /**
     * @return array
     */
    public function getLeadBoardData(): array {
        // 获取了所有的 Rankings: Get all rankings
        $rankings = $this->serviceResolver->rankingService()->buildRankingData(Ranking::AWARD_STATUS);
        $rankingsPlatinum = $this->serviceResolver->rankingService()->buildRankingData(Ranking::AWARD_PLATINUM);

        return compact('rankings', 'rankingsPlatinum');
    }

    /**
     * @return Reward
     */
    public function getRewardsData(): Reward {
        return $this->serviceResolver->rewardsService()->buildRewardsData();
    }

    /**
     * @param string $ytd
     * @return array
     */
    public function getStatusData(string $ytd) {
        return $this->serviceResolver->statusService()->buildStatusData($ytd);
    }

    /**
     * @param bool $isStacked
     * @return mixed|string
     */
    public function getMetricsData(bool $isStacked = false) {
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        return $isStacked ? $this->serviceResolver->metricsService()->buildStackedMetricsData($metrics)
            : $this->serviceResolver->metricsService()->buildMetricsData($metrics);
    }

    /**
     * @return Ranking|null
     */
    public function getCurrentRanking() {
        return $this->serviceResolver->rankingService()->getCurrentRanking();
    }

    /**
     * @return array
     */
    public function getHistoricalData(): array {
        return $this->serviceResolver->historicalService()->getHistoricalData();
    }

    /**
     * @param string $period
     * @param string $region
     * @return array
     */
    public function getIncentives(string $period, string $region) {
        switch ($period) {
            case 'current':
                return $this->serviceResolver->incentivesService()->current([$region]);
            case 'finished':
                return $this->serviceResolver->incentivesService()->justFinished([$region]);
            case 'past':
                return $this->serviceResolver->incentivesService()->past([$region]);
            case 'coming':
                return $this->serviceResolver->incentivesService()->upComing([$region]);
        }
    }

    /**
     * @return mixed
     */
    public function getFaqs() {
        return $this->serviceResolver->faqService()->load();
    }

    /**
     * @return mixed
     */
    public function getRegions() {
        return $this->serviceResolver->regionService()->load();
    }
}
