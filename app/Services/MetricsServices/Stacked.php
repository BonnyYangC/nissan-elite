<?php

namespace App\Services\MetricsServices;

use App\Helper\Utility;
use App\Helper\{Color, Defination};

class Stacked extends Base {

    /**
     * @param string $label
     * @param string $index
     * @param array $data
     * @return array
     */
    private function _buildDashboardMetricsChartData(string $type, string $index, string $label, array $data) {
        return [
            'label'=>$label,
            'backgroundColor' => COLOR::getColor(intVal($index), $type),
            'data'=>$data
        ];
    }

    /**
     * @param $trainingData
     * @return array
     */
    private function buildSharedMetricsData($trainingData) {
        $result = [];
        $shared = $this->getSharedMetrics();
        foreach ($shared as $id => $m) {
            $p = [];
            foreach(Utility::MONTHS_SHORT as $month) {
                $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                $value = isset($trainingData[$dateString]) ? $trainingData[$dateString] : null;
                $p[] = $value && isset($value[$m['identifier']]) ? $value[$m['identifier']] : 0;
            }
            $result[] = $this->_buildDashboardMetricsChartData(Defination::METRICS_TYPE_SHARED, $m['order'], $m['label'], $p);
        }
        return $result;
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
                    $value = isset($data[$dateString]) ? $data[$dateString] : null;
                    $tp[] = $this->buildMetricSummary($m, $value);
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

    /**
     * @param $trainingDefination
     * @param $trainingData
     * @return int|mixed
     */
    private function buildMetricSummary($trainingDefination, $trainingData) {
        $trainingPoints = 0;
        if(!$trainingData) return $trainingPoints;
        foreach($trainingDefination->metrics as $id => $cm) {
            $trainingPoints += isset($trainingData[$id]) ? $trainingData[$id] : 0;
        }
        return $trainingPoints;
    }

}