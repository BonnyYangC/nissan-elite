<?php

namespace App\Services\MetricsServices;

use App\Helper\Utility;
use Illuminate\Support\Facades\Auth;

class Base {
    protected $currentUser;
    public function __construct() {
        $this->currentUser = Auth::user();
    }

    /**
     * @return mixed
     */
    protected function getMetricsDefination() {
        return $this->currentUser->position->metrics->sortBy('order');
    }

    /**
     * @param $metricDefination
     * @param $metricsData
     * @return array
     */
    protected function buildMetricData($metricDefination, $metricsData) {
        $labels = ['Month'];
        $points = [];
        $scores = [];
        $childCount = count($metricDefination->guides);
        foreach($metricDefination->guides as $id => $cm) {
            $labels[] = $childCount === 1 ? 'Points' : $cm['label'];
        }
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = date('Y-m-01', strtotime($month));
            $p = [$month];
            foreach($metricDefination->guides as $id => $cm) {
                $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
                $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                $l = $childCount === 1 ? 'RESULT' : $cm['label'];
                $scores[$l][] = $value && isset($value[$id . '_result']) ? $value[$id . '_result'] : $cm['default'];
            }
            $points[] = $p;
        }
        return array(array_merge([$labels], $points), $scores);
    }

    /**
     * @param $metrics
     * @return mixed
     */
    public function buildMetricsData($metrics) {
        $metricsDefinations = $this->getMetricsDefination();

        $chartData = [];
        $tableData = [];

        foreach ($metricsDefinations as $m) {
            list($chartData[$m->identifier], $tableData[$m->identifier]) = $this->buildMetricData($m, $metrics);
        }

        $metricsDefinations->each(function($m) use ($chartData, $tableData) {
            $m->chart_data = json_encode($chartData[$m->identifier]);
            $m->table_data = $tableData[$m->identifier]; //['RESULT' => ['100','100','100','100','100','100','100','100','100','100','100','100'], '2' => ['100','100','100','100','100','100','100','100','100','100','100','100']];
            $m->chart_name = 'chart_'.$m->identifier;
        });
        return $metricsDefinations;
    }

    /**
     * @param $metricDefination
     * @param $metricsData
     * @return array
     */
    private function buildStackedMetricData($metricDefination, $metricsData) {
        $legends = ['genre'];
        $points = [];
        foreach ($metricDefination as $m) {
            foreach($m->guides as $id => $cm) {
                $legends[] = isset($cm['label']) ? $cm['label'] : 'Test';
            }
        };
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = date('Y-m-01', strtotime($month));
            $p = [$month];
            foreach ($metricDefination as $m) {
                foreach($m->guides as $id => $cm) {
                    $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
                    $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                }
            };
            $points[] = $p;
        }
        return array_merge([$legends], $points);
    }

    /**
     * @param $metrics
     * @return false|string
     */
    public function buildStackedMetricsData($metrics) {
        $metricsDefinations = $this->getMetricsDefination();
        return json_encode($this->buildStackedMetricData($metricsDefinations, $metrics));
    }
}
