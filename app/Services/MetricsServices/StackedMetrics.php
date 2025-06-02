<?php

namespace App\Services\MetricsServices;

use App\Repositories\ResultRepository;
use App\Services\{BaseService, ServiceResolver};
use App\Services\MetricsServices\Factories\StackedFactory;

class StackedMetrics extends BaseService {
  private $repository;
  private $factory;

  public function __construct(ServiceResolver $serviceResolver, ResultRepository $resultRepository, StackedFactory $factory) {
    parent::__construct($serviceResolver);
    $this->repository = $resultRepository;
    $this->factory = $factory;
  }

  public function get(string $positionCode) {
    $this->currentUser = $this->getCurrentUser();
    $results = $this->repository->getMetricsPointsByPosition($this->currentUser->employee_code, $positionCode);
    $metrics = $results->pluck('metrics', 'period');
    $trainingData = $results->keyBy('period');

    $service = $this->factory->make(theme_config('feature_metrics_stacked_combination') ? 'combined' : 'individual', $positionCode);
    return $service->buildStackedMetricsData($positionCode, $metrics, $trainingData);
  }
}