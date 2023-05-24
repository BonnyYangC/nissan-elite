<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\Dealer as BaseDealer;
use App\Models\Dealer as DealerModel;
use Carbon\Carbon;

class Dealer extends BaseDealer {

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return DealerModel
     */
    public function getModel($modelKey, $record, $key) {
        $model = DealerModel::where('code', trim($record[$modelKey['primary']]))->first();
        if(!$model){
            $model = new DealerModel();
            $model->parent_id = 1;
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
        }
        return $model;
    }
}
