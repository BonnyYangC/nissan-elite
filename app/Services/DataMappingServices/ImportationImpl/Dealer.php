<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Jobs\ProcessDealerRegion;
use App\Services\DataMappingServices\Dealer as BaseDealer;
use App\Models\Dealer as DealerModel;
use Carbon\Carbon;

class Dealer extends BaseDealer {

    use ImportTrait {
        ImportTrait::import as traitImport; // alias
    }

    public function importModel($row) {
        $timestamp = Carbon::now();
        $conditions = [
            'code' => trim($row['dcode'])
        ];
        $exists = DealerModel::where($conditions)->exists();
        $data = array_merge($this->buildData($row), [
            'updated_at' => $timestamp,
        ]);
        
        if (!$exists) {
            $data['created_at'] = $timestamp;
        }

        return DealerModel::updateOrInsert($conditions, $data);
    }

    public function import($headerFields, $rows){
        $returnValue = $this->traitImport($headerFields, $rows);
        //emit event to update dealer_regions
        ProcessDealerRegion::dispatch($returnValue['update']['data']);

        return $returnValue;
    }
}
