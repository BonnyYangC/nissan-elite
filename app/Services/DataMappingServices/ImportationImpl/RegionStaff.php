<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\RegionStaff as BaseRegionStaff;
use App\Models\User as RegionStaffModel;
use Carbon\Carbon;

class RegionStaff extends BaseRegionStaff {

    use ImportTrait;

    public function importModel($row) {
        $timestamp = Carbon::now();
        $conditions = [
            'email' => trim($row['Email']) //trim($record[$modelKey['primary']])
        ];
        $exists = RegionStaffModel::where($conditions)->exists();
        $data = array_merge($this->buildData($row), [
            'updated_at' => $timestamp,
        ]);
        
        if (!$exists) {
            $data['admin'] = 0;
            $data['password'] = bcrypt(strtoupper(trim($row['Surname'])).'1');
            $data['created_at'] = $timestamp;
        }

        return RegionStaffModel::updateOrInsert($conditions, $data);
    }
}
