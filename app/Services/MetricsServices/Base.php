<?php

namespace App\Services\MetricsServices;

use App\Helper\Defination;
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
        //dd((intval(config('elite.YEAR')) + 1));
        return intval($monthNum) <= 3 ? (intval(config('elite.YEAR'))+1).'-'.$monthNum.'-01' : config('elite.YEAR').'-'.$monthNum.'-01';
        //  $test = intval($monthNum) <= 3 ? (intval(config('elite.YEAR'))+1).'-'.$monthNum.'-01' : config('elite.YEAR').'-'.$monthNum.'-01';
        // var_dump($test);
    }

    /**
     * @return mixed
     */
    public function getSharedMetrics() {
        return Metric::where('type', '=', Defination::METRICS_TYPE_SHARED)
            ->where('year', config('elite.YEAR'))
            ->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return mixed
     */
    public function getAllMetricsByPosition(string $position) {
        return Metric::where('position', '=', $position)
            ->where('year', config('elite.YEAR'))
            ->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return Collection
     */
    public function getMetricsByPosition(string $position): Collection {
        return Metric::where('position', '=', $position)
            ->where('year', config('elite.YEAR'))
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
            ->where('year', config('elite.YEAR'))
            ->where('identifier', '=', Defination::METRICS_TYPE_TRAINING)->first();
    }
}
