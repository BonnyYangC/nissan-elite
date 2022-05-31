<?php

namespace App\Services\MetricsServices;

use App\Helper\Utility;
use App\Models\Metric;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Base {
    /** @var User  */
    protected $currentUser;

    private $monthArray = [
        'Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07', 'Aug'=>'08', 'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12', 'Jan'=>'01', 'Feb'=>'02', 'Mar'=>'03'
    ];

    /**
     * Base constructor.
     */
    public function __construct() {
        $this->currentUser = Auth::user();
    }

    /**
     * @param string $position
     * @return mixed
     */
    private function getAllMetricsByPosition(string $position) {
        //return $this->currentUser->position->metrics->sortBy('order');
        return Metric::where('position', '=', $position)->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return Collection
     */
    public function getMetricsByPosition(string $position): Collection {
        return Metric::where('position', '=', $position)->where('identifier', '!=', Metric::METRIC_TRAINING)->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return Metric
     */
    public function getTrainingMetricByPosition(string $position): Metric {
        return Metric::where('position', '=', $position)->where('identifier', '=', Metric::METRIC_TRAINING)->first();
    }

    /**
     * @param $trainingData
     * @return Metric
     */
    public function buildTrainingData($trainingData) {
        $trainingDefination = $this->getTrainingMetricByPosition($this->currentUser->position_code);
        $trainingDefination->chart_data = json_encode($this->buildStackedTrainingData($trainingDefination, $trainingData));
        $trainingDefination->chart_name = 'chart_'.$trainingDefination->identifier;
        return $trainingDefination;
    }

    /**
     * @param $trainingDefination
     * @param $trainingData
     * @return array
     */
    private function buildStackedTrainingData($trainingDefination, $trainingData) {
        $legends = ['Genre'];
        $points = [];
        foreach($trainingDefination->metrics as $id => $cm) {
            $legends[] = $cm['label'];
        }
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
            $p = [$month];
            foreach($trainingDefination->metrics as $id => $cm) {
                $value = isset($trainingData[$dateString]) ? $trainingData[$dateString] : null;
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
    public function buildMetricsData($metrics) {
        $metricsDefinations = $this->getMetricsByPosition($this->currentUser->position_code);
        $chartData = [];
        $tableData = [];

        foreach ($metricsDefinations as $m) {
            list($chartData[$m->identifier], $tableData[$m->identifier]) = $this->buildMetricData($m, $metrics);
        }

        $metricsDefinations->each(function($m) use ($chartData, $tableData) {
            $m->chart_data = json_encode($chartData[$m->identifier]);
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
    private function buildMetricData($metricDefination, $metricsData) {
        $legends = ['Month'];
        $points = [];
        $scores = [];
        $childCount = count($metricDefination->metrics);
        foreach($metricDefination->metrics as $id => $cm) {
            $legends[] = $childCount === 1 ? 'Points' : $cm['label'];
        }
        foreach(Utility::MONTHS_SHORT as $month) {
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

    /**
     * @param $metrics
     * @param $trainingData
     * @return false|string
     */
    public function buildStackedMetricsData($metrics, $trainingData) {
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
        $legends = ['Genre'];
        $points = [];
        foreach ($metricsDefinations as $m) {
            if($m->identifier === Metric::METRIC_TRAINING) {
                $legends[] = $m->label;
            } else {
                foreach ($m->metrics as $id => $cm) {
                    $legends[] = isset($cm['label']) ? $cm['label'] : '';
                }
            }
        };
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = $this->getDateString($month); //date('Y-m-01', strtotime($month));
            $p = [$month];
            foreach ($metricsDefinations as $m) {
                if($m->identifier === Metric::METRIC_TRAINING) {
                    $value = isset($trainingData[$dateString]) ? $trainingData[$dateString] : null;
                    $p[] = $this->buildTrainingSummary($m, $value);
                } else {
                    foreach ($m->metrics as $id => $cm) {
                        $value = isset($metricsData[$dateString]) ? $metricsData[$dateString] : null;
                        $p[] = $value && isset($value[$id]) ? $value[$id] : 0;
                    }
                }
            };
            $points[] = $p;
        }
        return array_merge([$legends], $points);
    }

    /**
     * @param $trainingDefination
     * @param $trainingData
     * @return int|mixed
     */
    private function buildTrainingSummary($trainingDefination, $trainingData) {
        $trainingPoints = 0;
        if(!$trainingData) return $trainingPoints;
        foreach($trainingDefination->metrics as $id => $cm) {
            $trainingPoints += $trainingData[$id];
        }
        return $trainingPoints;
    }

    private function getDateString($month) {
        return '2022-'.$this->monthArray[$month].'-01';
    }
}
