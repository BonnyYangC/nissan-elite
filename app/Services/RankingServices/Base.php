<?php

namespace App\Services\RankingServices;

use App\Helper\Defination;
use App\Models\Metric;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class Base {

    var $currentPeriod;
    var $valueObject;

    public function __construct($valueObject) {
      $this->valueObject = $valueObject;
    }


    public function getCurrentPeriod() {
        $thisPeriod = Ranking::getMaxPeriodByPositionAndCat($positions);
        if (!$thisPeriod) {
            $thisPeriod = date('Y-m').'-01';
        }
        if($action == Ranking::PREVIOUS){
            // 表示从查询到的 $thisPeriod 的上个月1号开始计算
            $thisPeriod->subMonth(1);
        }

    }
}