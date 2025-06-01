<?php

namespace App\Services\MetricsServices\StackedMetrics\Combined;

use App\Helper\{Defination, Utility};
use App\Models\Metric;
use App\Repositories\MetricsRepository;
use App\Services\MetricsServices\MetricsTrait;

class Stacked {
    use MetricsTrait;

    private $repository;
    private $combinedMetrics;
    private $position;

    public function __construct(MetricsRepository $repository, string $position) {
        $this->repository = $repository;
        $this->position = $position;
    }

    private function setCombinedMetrics($position) {
        $isD1Positioned = in_array($position, json_decode(theme_config('positions_with_D1')));
        $isF1Positioned = in_array($position, json_decode(theme_config('positions_with_F1')));
        return $isD1Positioned ? Metric::METRIC_D1 : Metric::METRIC_F1;
    }

    /**
     * @param $metrics
     * @param $trainingData
     * @return false|string
     */
    public function buildStackedMetricsData(string $positionCode, $metrics, $trainingData) {
        $metricsDefinations = $this->repository->getAllMetricsByPosition($positionCode);
        $this->combinedMetrics = $this->setCombinedMetrics($this->position);

        $returnValue = array_merge(
            $this->buildStackedMetricData($metricsDefinations, $metrics),
            $this->buildCombinedData($metricsDefinations, $metrics),
            $this->buildSharedMetricsData($trainingData),
            $this->buildTrainingData($metricsDefinations, $trainingData)
        );
        return json_encode($returnValue);
    }

    /**
     * CE Quality        (D1 + 5star        and       F1 + 5star)
     * CE Survey         (CE Survey)
     */
    private function buildCombinedData($metricsDefinations, $metricsData) {
        $filteredMetrics = $metricsDefinations->filter(function ($defination) {
            return in_array($defination->identifier, [$this->combinedMetrics, Metric::METRIC_5_STAR, Metric::METRIC_CE]);
        })->keyby('identifier');
        $result = [];
        $survey = [];
        $quality = [];
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
            $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
            if ($value) {
                $survey[] = isset($value['ce']) ? $value['ce'] : 0;
                $quality[] = intval(isset($value[$this->combinedMetrics]) ? $value[$this->combinedMetrics] : 0) + intval(isset($value['5_star']) ? $value['5_star'] : 0);
            }
        }
        $result[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $filteredMetrics['5_star']['order'], 'CE Quality', $quality);
        if(isset($filteredMetrics[Metric::METRIC_CE])) {
            $result[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $filteredMetrics['ce']['order'], 'CE Survey', $survey);
        }
        return $result;
    }

    private function buildStackedMetricData($metricsDefinations, $metricsData) {
        $points = [];
        $filteredMetrics = $metricsDefinations->filter(function ($defination) {
            return !in_array($defination->identifier, [$this->combinedMetrics, '5_star', 'ce', Defination::METRICS_TYPE_TRAINING]);
        });
        foreach ($filteredMetrics as $m) {
            if(count($m->metrics) > 1) {
                $tp = [];
                foreach(Utility::MONTHS_SHORT as $month) {
                    $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                    $value = data_get($metricsData, $dateString, null); //isset($data[$dateString]) ? $data[$dateString] : null;
                    $tp[] = $this->buildMetricSummary($m->metrics, $value);
                }
                $points[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $m['order'], $m['label'], $tp);
                continue;
            }
            foreach ($m->metrics as $id => $cm) {
                $p = [];
                foreach(Utility::MONTHS_SHORT as $month) {
                    $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                    $value = data_get($metricsData, $dateString, null);
                    $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                }
                $points[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $m['order'], $cm['label'], $p);
            }
        }
        return $points;
    }

    private function buildTrainingData($metricsDefinations, $trainingData): array {
        $points = [];
        $trainingMetric = $metricsDefinations->filter(function ($defination) {
            return $defination->identifier === Defination::METRICS_TYPE_TRAINING;
        })->first();

        $tp = [];
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = $this->getDateString($month);
            $value = data_get($trainingData, $dateString, null);
            $tp[] = $this->buildMetricSummary($trainingMetric->metrics, $value);
        }
        $points[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_CUSTOM, $trainingMetric['order'], $trainingMetric['label'], $tp);

        return $points;
    }
}