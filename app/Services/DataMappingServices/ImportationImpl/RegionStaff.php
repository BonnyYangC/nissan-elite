<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\RegionStaff as BaseRegionStaff;
use App\Models\User as RegionStaffModel;
use Carbon\Carbon;

class RegionStaff extends BaseRegionStaff {

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return RegionStaffModel
     */
    public function getModel($modelKey, $record, $key) {
        $model = RegionStaffModel::where('Email', trim($record[$modelKey['primary']]))->first();
        if(!$model){
            $model = new RegionStaffModel();
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
            $model->admin = 0;
            list($firstName, $surName) = explode(' ', $record['Name']);
            $model->password = bcrypt(strtoupper(trim($surName)).'1');
        }
        
        return $model;
    }
}
