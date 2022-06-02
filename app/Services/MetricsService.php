<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MetricsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return mixed|string
     */
    public function getMetricsData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $service = new MetricsServices\Individual();
        return $service->buildMetricsData($metrics);
    }

    /**
     * @return Metric|void
     */
    public function getTrainingData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $trainingData = $currentUser->results()->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = new MetricsServices\Individual();
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
