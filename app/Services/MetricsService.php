<?php

namespace App\Services;

use App\Models\Metric;
use App\Repositories\ResultRepository;
use App\Services\MetricsServices as MS;

class MetricsService extends BaseService {

    private $repository;

    public function __construct(ServiceResolver $serviceResolver, ResultRepository $resultRepository) {
        parent::__construct($serviceResolver);
        $this->repository = $resultRepository;
    }

    /**
     * @return mixed|string
     */
    public function getMetricsData(string $positionCode) {
        $currentUser = $this->getCurrentUser();
        $results = $this->repository->getMetricsPointsByPosition($currentUser->employee_code, $positionCode);
        $metrics = $results->pluck('metrics', 'period');
        $service = (new MS\Metrics\Metrics())->get($this->serviceResolver);
        return $service->buildMetricsData($positionCode, $metrics);
    }

    /**
     * @return Metric|array
     */
    public function getTrainingData(string $positionCode) {
        $currentUser = $this->getCurrentUser();
        $results = $this->repository->getMetricsPointsByPosition($currentUser->employee_code, $positionCode);
        $trainingData = $results->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = (new MS\Metrics\Metrics())->get($this->serviceResolver);
        return $service->buildTrainingData($positionCode, $trainingData);
    }

    /**
     * @return false|string
     */
    public function getStackedMetricsData(string $positionCode) {
        $results = $this->repository->getMetricsPointsByPosition($this->currentUser->employee_code, $positionCode);
        $metrics = $results->pluck('metrics', 'period');
        $trainingData = $results->keyBy('period');
        
        $service = (new MS\StackedMetrics\Stacked())->byPosition($positionCode)->get($this->serviceResolver);
        return $service->buildStackedMetricsData($positionCode, $metrics, $trainingData);
    }
}
