<?php

namespace App\Services\MetricsServices\StackedMetrics\Individual;

use App\Helper\{Defination, Utility};
use App\Repositories\MetricsRepository;
use App\Services\MetricsServices\MetricsTrait;

class Stacked {

    use MetricsTrait;

    private $repository;
    private $position;

    public function __construct(MetricsRepository $repository, string $position) {
        $this->repository = $repository;
        $this->position = $position;
    }

    /**
     * @param $metrics
     * @param $trainingData
     * @return false|string
     */
    public function buildStackedMetricsData(string $positionCode, $metrics, $trainingData) {
        $metricsDefinations = $this->repository->getAllMetricsByPosition($positionCode);
        $returnValue = array_merge(
            $this->buildStackedMetricData($metricsDefinations, $metrics, $trainingData),
            $this->buildSharedMetricsData($trainingData)
        );
        return json_encode($returnValue);
    }

    /**
     * @param $metricsDefinations
     * @param $metricsData
     * @param $trainingData
     * @return array
     */
    private function buildStackedMetricData($metricsDefinations, $metricsData, $trainingData) {
        $points = [];
        foreach ($metricsDefinations as $m) {
            if(count($m->metrics) > 1) {
                $tp = [];
                $data = $m->identifier === Defination::METRICS_TYPE_TRAINING ? $trainingData : $metricsData;
                foreach(Utility::MONTHS_SHORT as $month) {
                    $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                    $value = data_get($data, $dateString, null); //isset($data[$dateString]) ? $data[$dateString] : null;
                    $tp[] = $this->buildMetricSummary($m->metrics, $value);
                }
                $points[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $m['order'], $m['label'], $tp);
                continue;
            }
            foreach ($m->metrics as $id => $cm) {
                $p = [];
                foreach(Utility::MONTHS_SHORT as $month) {
                    $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                    $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
                    $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                }
                $points[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $m['order'], $cm['label'], $p);
            }
        }
        return $points;
    }


}