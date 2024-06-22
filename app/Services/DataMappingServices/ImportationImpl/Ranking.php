<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Helper\Utility;
use App\Services\DataMappingServices\Ranking as BaseRanking;
use App\Models\Ranking as RankingModel;

class Ranking extends BaseRanking {
    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $modelKey
     * @param $record
     * @return RankingModel
     */
    public function getModel($modelKey, $record, $key) {
        $model = RankingModel::where('employee_code', trim($record[$modelKey['primary']]))
            ->where('period', Utility::formatPeriod($record['mthyr_g_']))->first();
        if(!$model){
            $model = RankingModel::factory()->make();
        }
        return $model;
    }
}
