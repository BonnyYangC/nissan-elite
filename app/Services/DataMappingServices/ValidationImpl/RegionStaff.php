<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Services\DataMappingServices\RegionStaff as BaseRegionStaff;
use App\Models\User as RegionStaffModel;

class RegionStaff extends BaseRegionStaff {
    use ValidationTrait;
    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return RegionStaffModel
     */
    public function getModel($modelKey, $record) {
        // $model = RegionStaffModel::where('email', trim($record[$modelKey['primary']]))->first();
        $model = RegionStaffModel::where('email', 'like', '%'.trim($record[$modelKey['primary']]).'%')->first();
        return $model;
    }
}
