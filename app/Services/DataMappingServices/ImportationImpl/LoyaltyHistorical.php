<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\LoyaltyHistorical as BaseLoyaltyHistorical;
use App\Models\History;

class LoyaltyHistorical extends BaseLoyaltyHistorical {
/**
     * get model according data file type
     *
     * @param $actionType
     * @param $modelKey
     * @param $record
     * @return History
     */
    public function getModel($modelKey, $record, $key) {
        $model = History::where('member_id', trim($record[$modelKey['primary']]))
            ->where('period', trim($modelKey['mapping'][$key]))->first();
        if(!$model){
            $model = new History();
        }
        return $model;
    }
  }