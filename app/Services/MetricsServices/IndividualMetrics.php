<?php

namespace App\Services\MetricsServices;

use App\Repositories\ResultRepository;
use App\Services\{BaseService, ServiceResolver};
use App\Services\MetricsServices\Factories\IndividualFactory;

class IndividualMetrics extends BaseService {
  private $repository;
  private $factory;

  public function __construct(ServiceResolver $serviceResolver, ResultRepository $resultRepository, IndividualFactory $factory) {
    parent::__construct($serviceResolver);
    $this->repository = $resultRepository;
    $this->factory = $factory;
  }

  public function get(string $positionCode) {
    $currentUser = $this->getCurrentUser();
    $results = $this->repository->getMetricsPointsByPosition($currentUser->employee_code, $positionCode);
    $metrics = $results->pluck('metrics', 'period');
    $service = $this->factory->make('individual');
    return $service->buildMetricsData($positionCode, $metrics);
  }
}