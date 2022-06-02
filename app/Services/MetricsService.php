<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\{Metric, User};
use App\Services\MetricsServices as MS;
use Illuminate\Support\Facades\Auth;

class MetricsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    public function getMetricsService($positon) {
        switch ($positon) {
            case Role::PARTS_SALES_REP:
                return new MS\PartsSalesRep();
            default:
                return new MS\Individual();
        }
    }

    /**
     * @return mixed|string
     */
    public function getMetricsData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $service = $this->getMetricsService($currentUser->position_code); //new MetricsServices\Individual();
        return $service->buildMetricsData($metrics);
    }

    /**
     * @return Metric|void
     */
    public function getTrainingData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $trainingData = $currentUser->results()->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = $this->getMetricsService($currentUser->position_code); //new MetricsServices\Individual();
        return $service->buildTrainingData($trainingData);
    }

    /**
     * @return false|string
     */
    public function getStackedMetricsData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $trainingData = $currentUser->results()->keyBy('period');
        $service = new MetricsServices\Stacked();
        return $service->buildStackedMetricsData($metrics, $trainingData);
    }
}
