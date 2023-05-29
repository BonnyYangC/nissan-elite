<?php

namespace App\Services\MetricsServices;

use App\Helper\Utility;
use App\Models\Metric;

class Individual extends Base {

    /**
     * @param $data
     * @return Metric
     */
    public function buildTrainingData(string $positionCode, $data) {
        $trainingDefination = $this->getTrainingMetricByPosition($positionCode);
        $trainingDefination->chart_data = json_encode($this->buildStackedTrainingData($trainingDefination, $data));
        $trainingDefination->chart_name = 'chart_'.$trainingDefination->identifier;
        return $trainingDefination;
    }

    /**
     * @param $defination
     * @param $data
     * @return array
     */
    private function buildStackedTrainingData($defination, $data) {
        $legends = ['Genre'];
        $points = [];
        foreach($defination->metrics as $id => $cm) {
            $legends[] = $cm['label'];
        }
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
            $p = [$month];
            foreach($defination->metrics as $id => $cm) {
                $value = isset($data[$dateString]) ? $data[$dateString] : null;
                $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
            }
            $points[] = $p;
        }
        return array_merge([$legends], $points);
    }

    /**
     * @param $metrics
     * @return mixed
     */
    public function buildMetricsData(string $positionCode, $metrics) {
        $metricsDefinations = $this->getMetricsByPosition($positionCode);
        $chartData = [];
        $tableData = [];

        foreach ($metricsDefinations as $m) {
            list($chartData[$m->identifier], $tableData[$m->identifier]) = $this->buildMetricData($m, $metrics);
        }

        $metricsDefinations->each(function($m) use ($chartData, $tableData) {
            $m->chart_data = json_encode($chartData[$m->identifier]);
            $m->table_header = $m->period === self::METRIC_PERIOD_QUARTERLY ? Utility::QUARTERLY_MONTHS_SHORT : Utility::MONTHS_SHORT;
            $m->table_data = isset($tableData[$m->identifier]) ? $tableData[$m->identifier] : []; //['RESULT' => ['100','100','100','100','100','100','100','100','100','100','100','100'], '2' => ['100','100','100','100','100','100','100','100','100','100','100','100']];
            $m->chart_name = 'chart_'.$m->identifier;
        });
        return $metricsDefinations;
    }

    /**
     * @param $metricDefination
     * @param $metricsData
     * @return array
     */
    protected function buildMetricData($metricDefination, $metricsData) {
        $legends = ['Month'];
        $points = [];
        $scores = [];
        $childCount = count($metricDefination->metrics);
        foreach($metricDefination->metrics as $id => $cm) {
            $legends[] = $childCount === 1 ? 'Points' : $cm['label'];
        }
        $months = $metricDefination->period === self::METRIC_PERIOD_QUARTERLY ? Utility::QUARTERLY_MONTHS_SHORT : Utility::MONTHS_SHORT;
        foreach($months as $month) {
            $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
            $p = [$month];
            foreach($metricDefination->metrics as $id => $cm) {
                $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
                $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                $l = $childCount === 1 ? 'RESULT' : $cm['label'];
                $scores[$l][] = $value && isset($value[$id . '_result']) ? $value[$id . '_result'] : $cm['default'];
            }
            $points[] = $p;
        }
        return array(array_merge([$legends], $points), $scores);
    }
}
