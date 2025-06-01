<?php

namespace App\Services\MetricsServices;

use App\Repositories\ResultRepository;
use App\Services\{BaseService, ServiceResolver};
use App\Services\MetricsServices as MS;

class StackedMetrics extends BaseService
{
  private $repository;

  public function __construct(ServiceResolver $serviceResolver, ResultRepository $resultRepository) {
    parent::__construct($serviceResolver);
    $this->repository = $resultRepository;
  }

  public function get(string $positionCode) {
    $this->currentUser = $this->getCurrentUser();
    $results = $this->repository->getMetricsPointsByPosition($this->currentUser->employee_code, $positionCode);
    $metrics = $results->pluck('metrics', 'period');
    $trainingData = $results->keyBy('period');
    
    $service = (new MS\StackedMetrics\Stacked())->byPosition($positionCode)->get($this->serviceResolver);
    return $service->buildStackedMetricsData($positionCode, $metrics, $trainingData);
  }
}