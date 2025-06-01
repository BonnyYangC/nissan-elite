<?php

namespace App\Services\MetricsServices;

use App\Repositories\ResultRepository;
use App\Services\{BaseService, ServiceResolver};
use App\Services\MetricsServices\Factories\TrainingFactory;

class TrainingMetrics extends BaseService {
  private $repository;
  private $factory;

  public function __construct(ServiceResolver $serviceResolver, ResultRepository $resultRepository, TrainingFactory $factory) {
    parent::__construct($serviceResolver);
    $this->repository = $resultRepository;
    $this->factory = $factory;
  }

  public function get(string $positionCode) {
    $currentUser = $this->getCurrentUser();
    $results = $this->repository->getMetricsPointsByPosition($currentUser->employee_code, $positionCode);
    $trainingData = $results->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
    $service = $this->factory->make('training');
    return $service->buildTrainingData($positionCode, $trainingData);
  }
}