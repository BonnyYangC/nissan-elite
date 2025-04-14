<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Helper\Defination;
use App\Services\DataMappingServices\TerritoryReport as BaseTerritoryReport;
use App\Models\TerritoryReport as TerritoryReportModel;
use App\Models\User;
use Carbon\Carbon;

class TerritoryReport extends BaseTerritoryReport {
    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $modelKey
     * @param $record
     * @return TerritoryReportModel
     */
    public function getModel($modelKey, $record, $key) {
        // $this->handleUser(trim($record[$modelKey['primary']]), $actionType);
        $model = TerritoryReportModel::where('employee_code', trim($record[$modelKey['primary']]))->first();
        if(!$model){
            $model = TerritoryReportModel::factory()->make();
            // $model = new TerritoryReportModel();
            // $model->updated_at = Carbon::now();
            // $model->created_at = Carbon::now();
        }
        return $model;
    }

 
}
