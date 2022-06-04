<?php

namespace App\Services\MetricsServices;

use App\Models\Metric;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Base extends BaseService {

    private $monthArray = [
        'Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07', 'Aug'=>'08', 'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12', 'Jan'=>'01', 'Feb'=>'02', 'Mar'=>'03'
    ];

    /**
     * @param $month
     * @return string
     */
    protected function getDateString($month) {
        return '2022-'.$this->monthArray[$month].'-01';
    }

    /**
     * @return mixed
     */
    public function getSharedMetrics() {
        return Metric::where('type', '=', Metric::TYPE_SHARED)->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return mixed
     */
    public function getAllMetricsByPosition(string $position) {
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
}
