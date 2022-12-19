<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\Metric;
use App\Services\MetricsServices as MS;

class MetricsService extends BaseService {

    /**
     * @param string $position
     * @return MS\FleetSalesExecutives|MS\Individual|MS\PartsSalesRep
     */
    public function getMetricsService(string $position) {
        switch ($position) {
            case Role::PARTS_SALES_REP:
                return new MS\PartsSalesRep($this->serviceResolver);
            case Role::FLEET_SALES_EXECUTIVES:
                return new MS\FleetSalesExecutives($this->serviceResolver);
            default:
                return new MS\Individual($this->serviceResolver);
        }
    }

    /**
     * @return mixed|string
     */
    public function getMetricsData() {
        $currentUser = $this->getCurrentUser();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $service = $this->getMetricsService($currentUser->position_code); //new MetricsServices\Individual();
        return $service->buildMetricsData($metrics);
    }

    /**
     * @return Metric|void
     */
    public function getTrainingData() {
        $currentUser = $this->getCurrentUser();
        $trainingData = $currentUser->results()->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = $this->getMetricsService($currentUser->position_code); //new MetricsServices\Individual();
        return $service->buildTrainingData($trainingData);
    }

    /**
     * @return false|string
     */
    public function getStackedMetricsData() {
        $metrics = $this->currentUser->results()->pluck('metrics', 'period');
        $trainingData = $this->currentUser->results()->keyBy('period');
        $service = new MetricsServices\Stacked($this->serviceResolver);
        return $service->buildStackedMetricsData($metrics, $trainingData);
    }
}
