<?php

namespace App\Services;

use App\Helper\Role;
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
     * @param string $position
     * @return MS\FleetSalesExecutives|MS\Individual|MS\PartsSalesRep
     */
    public function getMetricsService(string $position) {
        // switch ($position) {
        //     case Role::PARTS_SALES_REP:
        //         return new MS\PartsSalesRep($this->serviceResolver);
        //     case Role::FLEET_SALES_EXECUTIVES:
        //         return new MS\FleetSalesExecutives($this->serviceResolver);
        //     default:
        //         return new MS\Individual($this->serviceResolver);
        // }
        return new MS\Individual($this->serviceResolver);
    }

    /**
     * @return mixed|string
     */
    public function getMetricsData(string $positionCode) {
        $currentUser = $this->getCurrentUser();
        $results = $this->repository->getMetricsPointsByPosition($currentUser->employee_code, $positionCode);
        $metrics = $results->pluck('metrics', 'period');
        $service = $this->getMetricsService($positionCode); //new MetricsServices\Individual();
        return $service->buildMetricsData($positionCode, $metrics);
    }

    /**
     * @return Metric|void
     */
    public function getTrainingData(string $positionCode): Metric {
        $currentUser = $this->getCurrentUser();
        $results = $this->repository->getMetricsPointsByPosition($currentUser->employee_code, $positionCode);
        $trainingData = $results->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = $this->getMetricsService($positionCode); //new MetricsServices\Individual();
        return $service->buildTrainingData($positionCode, $trainingData);
    }

    /**
     * @return false|string
     */
    public function getStackedMetricsData(string $positionCode) {
        $results = $this->repository->getMetricsPointsByPosition($this->currentUser->employee_code, $positionCode);
        $metrics = $results->pluck('metrics', 'period');
        $trainingData = $results->keyBy('period');
        $service = new MetricsServices\Stacked($this->serviceResolver);
        return $service->buildStackedMetricsData($positionCode, $metrics, $trainingData);
    }
}
