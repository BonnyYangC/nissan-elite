<?php

namespace App\Services\MetricsServices\StackedMetrics\Themed;

use App\Helper\Defination;
use App\Helper\Utility;
use App\Models\Metric;
use App\Services\MetricsServices\Base;

class Stacked extends Base
{
    private $combinedMetrics;

    public function setCombinedMetrics($value) {
        $this->combinedMetrics = $value;
        return $this;
    }

    /**
     * @param $metrics
     * @param $trainingData
     * @return false|string
     */
    public function buildStackedMetricsData(string $positionCode, $metrics, $trainingData) {
        $metricsDefinations = $this->getAllMetricsByPosition($positionCode);

        $returnValue = array_merge(
            $this->buildStackedMetricData($metricsDefinations, $metrics, $trainingData),
            $this->buildCombinedData($metricsDefinations, $metrics),
            $this->buildSharedMetricsData($trainingData)
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

    private function buildStackedMetricData($metricsDefinations, $metricsData, $trainingData) {
        $points = [];
        $filteredMetrics = $metricsDefinations->filter(function ($defination) {
            return !in_array($defination->identifier, [$this->combinedMetrics, '5_star', 'ce']);
        });
        foreach ($filteredMetrics as $m) {
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