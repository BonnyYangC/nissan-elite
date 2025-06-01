<?php

namespace App\Services\MetricsServices\TrainingMetrics;

use App\Helper\Utility;
use App\Repositories\MetricsRepository;
use App\Services\MetricsServices\MetricsTrait;

class Metrics {

  use MetricsTrait;

  private $repository;

  public function __construct(MetricsRepository $repository) {
    $this->repository = $repository;
  }

  public function buildTrainingData(string $positionCode, $data) {
    $trainingDefination = $this->repository->getTrainingMetricByPosition($positionCode);
    if (!$trainingDefination)
        return [];
    $trainingDefination->chart_data = json_encode($this->buildStackedTrainingData($trainingDefination, $data));
    $trainingDefination->chart_name = 'chart_'.$trainingDefination->identifier;
    return $trainingDefination;
  }

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
}