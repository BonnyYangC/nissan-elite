<?php

namespace App\Services\MetricsServices;

use App\Helper\Color;
use App\Helper\Defination;
use App\Helper\Utility;
use App\Models\Metric;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class Base extends BaseService {

    const METRIC_PERIOD_QUARTERLY = 'quarterly';
    private $monthArray = [
        'Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07', 'Aug'=>'08', 'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12', 'Jan'=>'01', 'Feb'=>'02', 'Mar'=>'03'
    ];

    /**
     * @param $month
     * @return string
     */
    protected function getDateString($month) {
        $monthNum = $this->monthArray[$month];
        return intval($monthNum) <= 3 ? (intval(config('view.theme'))+1).'-'.$monthNum.'-01' : config('view.theme').'-'.$monthNum.'-01';
        //  $test = intval($monthNum) <= 3 ? (intval(config('view.theme'))+1).'-'.$monthNum.'-01' : config('view.theme').'-'.$monthNum.'-01';
    }

    /**
     * @param string $label
     * @param string $index
     * @param array $data
     * @return array
     */
    protected function _buildDashboardMetricsChartData(string $type, string $index, string $label, array $data) {
        return [
            'label'=>$label,
            'backgroundColor' => COLOR::getColor(intVal($index), $type),
            'data'=>$data
        ];
    }

    /**
     * @param $metrics
     * @param $metricPoints
     * @return int|mixed
     */
    protected function buildMetricSummary($metrics, $metricPoints) {
        $summaryPoints = 0;
        if(!$metricPoints) return $summaryPoints;
        foreach($metrics as $id => $cm) {
            // if this metric has points
            $hasPoints = data_get($cm, 'has_points', true);
            if (!$hasPoints) continue;
            // if points is empty, use default points from metric defination
            $summaryPoints += $metricPoints[$id] !== '' ? $metricPoints[$id] : data_get($cm, 'point_default');
        }
        return $summaryPoints;
    }


    /**
     * @param $trainingData
     * @return array
     */
    protected function buildSharedMetricsData($trainingData) {
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
     * @return mixed
     */
    public function getSharedMetrics() {
        return Metric::where('type', '=', Defination::METRICS_TYPE_SHARED)
            ->where('year', config('view.theme'))
            ->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return mixed
     */
    public function getAllMetricsByPosition(string $position) {
        return Metric::where('position', '=', $position)
            ->where('year', config('view.theme'))
            ->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return Collection
     */
    public function getMetricsByPosition(string $position): Collection {
        return Metric::where('position', '=', $position)
            ->where('year', config('view.theme'))
            ->where('identifier', '!=', Defination::METRICS_TYPE_TRAINING)
            ->orderBy('order')
            ->get();
    }

    /**
     * @param string $position
     * @return Metric
     */
    public function getTrainingMetricByPosition(string $position): Metric {
        return Metric::where('position', '=', $position)
            ->where('year', config('view.theme'))
            ->where('identifier', '=', Defination::METRICS_TYPE_TRAINING)->first();
    }
}
