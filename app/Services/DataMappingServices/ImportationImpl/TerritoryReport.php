<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\TerritoryReport as BaseTerritoryReport;
use App\Models\TerritoryReport as TerritoryReportModel;
use Carbon\Carbon;

class TerritoryReport extends BaseTerritoryReport {

    use ImportTrait;

    public function importModel($row) {
        $timestamp = Carbon::now();
        $conditions = [
            'employee_code' => trim($row['regi#_']), //$record[$modelKey['primary']])
        ];
        $exists = TerritoryReportModel::where($conditions)->exists();
        $data = array_merge($this->buildData($row), [
            'updated_at' => $timestamp,
        ]);
        
        if (!$exists) {
            $data['created_at'] = $timestamp;
        }

        return TerritoryReportModel::updateOrInsert($conditions, $data);
    }
}
