<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Services\DataMappingServices\Dealer as BaseDealer;
use App\Models\Dealer as DealerModel;

class Dealer extends BaseDealer {
    use ValidationTrait;

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return DealerModel
     */
    public function getModel($modelKey, $record, $key) {
        return DealerModel::where('code', trim($record[$modelKey['primary']]))->first();
    }
}
