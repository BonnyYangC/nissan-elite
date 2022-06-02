<?php

namespace App\Services\MetricsServices;

use App\Helper\Utility;
use App\Models\Metric;

class PartsSalesRep extends Individual {

    const METRIC_TRADE_SALES = 'trade_sale';

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
        $months = $metricDefination->identifier === self::METRIC_TRADE_SALES ? Utility::QUARTERLY_MONTHS_SHORT : Utility::MONTHS_SHORT;
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