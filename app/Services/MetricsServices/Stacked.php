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
     * @var Carbon $startPoint
     * To generate the array's key when iterate the MetricsService data
     */
    protected $startPoint = null;

    protected $excellence = [];
    protected $registration = [];


        //$this->startPoint = Carbon::createFromDate(configuration('YEAR'),3,1,env('DEFAULT_TIMEZONE'));


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
     * build MetricsService data for dashboard MetricsService chart
     * @param array $excellence
     * @param array $registration
     * @return array
     */
    public function getBaseMetrics() {
        return [
            $this->_buildDashboardMetricsChartData('Dealer Excellence', IColor::GAINS_BORO, $this->excellence),
            $this->_buildDashboardMetricsChartData('Registration', IColor::DARK_GREEN, $this->registration),
        ];
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
        return json_encode($this->buildStackedMetricData($metricsDefinations, $metrics, $trainingData));
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