<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\Metric;
use App\Services\MetricsServices as MS;

class MetricsService extends BaseService {

    /**
     * @param string $position
     * @return MS\Individual|MS\PartsSalesRep
     */
    public function getMetricsService(string $position) {
        switch ($position) {
            case Role::PARTS_SALES_REP:
                return new MS\PartsSalesRep($this->serviceResolver);
            default:
                return new MS\Individual($this->serviceResolver);
        }
    }

    /**
     * @return mixed|string
     */
    public function getMetricsData() {
        $metrics = $this->currentUser->results()->pluck('metrics', 'period');
        $service = $this->getMetricsService($this->currentUser->position_code); //new MetricsServices\Individual();
        return $service->buildMetricsData($metrics);
    }

    /**
     * @return Metric|void
     */
    public function getTrainingData() {
        $trainingData = $this->currentUser->results()->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = $this->getMetricsService($this->currentUser->position_code); //new MetricsServices\Individual();
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
