<?php

namespace App\Services\MetricsServices\IndividualMetrics;

use App\Helper\Utility;
use App\Models\Metric;
use App\Repositories\MetricsRepository;
use App\Services\MetricsServices\MetricsTrait;

class Metrics {

  use MetricsTrait;

  private $repository;
  private $formator;

  public function __construct(MetricsRepository $repository, Formator $formator) {
    $this->repository = $repository;
    $this->formator = $formator;
  }

  public function buildMetricsData(string $positionCode, $metricsValue) {
    $metricsDefinations = $this->repository->getMetricsByPosition($positionCode);
    $chartData = [];
    $tableData = [];

    foreach ($metricsDefinations as $m) {
        $m->metrics = (count($m->metrics) > 1) ? $this->sortingMetricsByOrder($m->metrics) : $m->metrics;
        list($chartData[$m->identifier], $tableData[$m->identifier]) = $this->buildMetricData($m, $metricsValue);
    }

    $metricsDefinations->each(function($m) use ($chartData, $tableData) {
        $m->chart_data = json_encode($chartData[$m->identifier]);
        $m->table_header = $m->period === Metric::METRIC_PERIOD_QUARTERLY ? Utility::QUARTERLY_MONTHS_SHORT : Utility::MONTHS_SHORT;
        $m->table_data = isset($tableData[$m->identifier]) ? $tableData[$m->identifier] : []; //['RESULT' => ['100','100','100','100','100','100','100','100','100','100','100','100'], '2' => ['100','100','100','100','100','100','100','100','100','100','100','100']];
        $m->chart_name = 'chart_'.$m->identifier;
        $style = [];
        foreach ($m->metrics as $key => $cm) {
            if (!isset($cm['score_style'])) continue;
            $style[$cm['label']] = $cm['score_style'];
        }
        $m->table_style = $style;
    });
    return $metricsDefinations;
  }

  private function buildMetricData($metricDefination, $metricValue) {
    $legends = ['Month']; // ['Month', 'Points'] or ['Month', 'NIC sale', 'NIC Financed']
    $points = [];
    $scores = [];
    $childCount = count($this->getMetricsHasPoints($metricDefination->metrics));

    foreach($metricDefination->metrics as $id => $cm) {
        if (!data_get($cm, 'has_points', true)) continue;
        $legends[] = $childCount === 1 ? 'Points' : $cm['label'];
    }

    $months = $metricDefination->period === Metric::METRIC_PERIOD_QUARTERLY ? Utility::QUARTERLY_MONTHS_SHORT : Utility::MONTHS_SHORT;
    foreach($months as $month) {
        $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
        $p = [$month];
        foreach($metricDefination->metrics as $id => $cm) {
            $value = isset($metricValue[$dateString]) ? $metricValue[$dateString] : null;
            if(data_get($cm, 'has_points', true)) {
                $p[] = $value && isset($value[$id]) && $value[$id] !== '' ? intVal($value[$id]) : data_get($cm, 'point_default', 0);
            }
            $l = ($childCount === 1 && data_get($cm, 'has_points', true)) ? 'RESULT' : $cm['label'];
    
            $scores[$l][] = $value && isset($value[$id . '_result']) ?
                $this->formator->process($cm, $value[$id . '_result']) : data_get($cm, 'score_default', 0);
        }
        $points[] = $p;
    }
    return array(array_merge([$legends], $points), $scores);
  }

  private function getMetricsHasPoints($metrics) {
    return array_filter($metrics, function($v, $k) {
        return data_get($v, 'has_points', true);
    }, ARRAY_FILTER_USE_BOTH);
  }

  private function sortingMetricsByOrder($metrics) {
    uasort($metrics, function ($a, $b) {
        if (intVal(data_get($a, 'score_order', 0)) == intVal(data_get($b, 'score_order', 0))) {
            return 0;
        }
        return (intVal(data_get($a, 'score_order', 0)) < intVal(data_get($b, 'score_order', 0))) ? -1 : 1;
    });
    return $metrics;
  }

}