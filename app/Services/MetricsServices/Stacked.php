<?php

namespace App\Services\MetricsServices;

use App\Helper\Utility;
use App\models\IColor;
use App\Models\Metric;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Stacked extends Base {

    /**
     * @param string $label
     * @param string $backgroundColor
     * @param array $data
     * @return array
     */
    private function _buildDashboardMetricsChartData(string $label, string $backgroundColor, array $data) {
        return [
            'label'=>$label,
            'backgroundColor' => $backgroundColor,
            'data'=>$data
        ];
    }

    /**
     * @param $trainingData
     * @return array
     */
    private function buildCommonMetricsData($trainingData) {
        $result = [];
        $shared = $this->getSharedMetrics();
        foreach ($shared as $id => $m) {
            $p = [];
            foreach(Utility::MONTHS_SHORT as $month) {
                $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                $value = isset($trainingData[$dateString]) ? $trainingData[$dateString] : null;
                $p[] = $value && isset($value[$m['identifier']]) ? $value[$m['identifier']] : 0;
            }
            $result[] = $this->_buildDashboardMetricsChartData($m['label'], $m['color'], $p);
        }
        return $result;
    }


    /**
     * @param $metrics
     * @param $trainingData
     * @return false|string
     */
    public function buildStackedMetricsData($metrics, $trainingData) {
        /** @var User $currentUser */
        // $currentUser = Auth::user();
        $metricsDefinations = $this->getAllMetricsByPosition($this->currentUser->position_code);
        return json_encode(array_merge($this->buildStackedMetricData($metricsDefinations, $metrics, $trainingData),
            $this->buildCommonMetricsData($trainingData)
        ));
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
                $data = $m->identifier === Metric::METRIC_TRAINING ? $trainingData : $metricsData;
                foreach(Utility::MONTHS_SHORT as $month) {
                    $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                    $value = isset($data[$dateString]) ? $data[$dateString] : null;
                    $tp[] = $this->buildMetricSummary($m, $value);
                }
                $points[] = $this->_buildDashboardMetricsChartData($m['label'], $m['color'], $tp);
                continue;
            }
            foreach ($m->metrics as $id => $cm) {
                $p = [];
                foreach(Utility::MONTHS_SHORT as $month) {
                    $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
                    $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
                    $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                }
                $points[] = $this->_buildDashboardMetricsChartData($cm['label'], $cm['color'], $p);
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
            $trainingPoints += $trainingData[$id];
        }
        return $trainingPoints;
    }

}