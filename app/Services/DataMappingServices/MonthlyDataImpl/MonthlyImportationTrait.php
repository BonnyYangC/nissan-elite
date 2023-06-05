<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Models\Result;
use Carbon\Carbon;
use App\Helper\Utility;

trait MonthlyImportationTrait {
    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $modelKey
     * @param $record
     * @return Result
     */
    public function getModelForImportation($modelKey, $record, $key) {
        $model = Result::where('employee_code', trim($record[$modelKey['primary']]))
            ->where('period', Utility::formatPeriod($record['mthyrg']))->first();
        if(!$model){
            $model = new Result();
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
        }
        return $model;
    }
}
