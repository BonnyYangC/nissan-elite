<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Jobs\{ProcessHistorical, ProcessUserPosition};
use App\Services\DataMappingServices\MonthlyDataMapping;
use App\Models\Result;
use App\Helper\Utility;
use Carbon\Carbon;

class IndividualMonthly extends MonthlyDataMapping {

    use ImportTrait {
        ImportTrait::import as traitImport; // alias
    }

    public function importModel($row) {
        $timestamp = Carbon::now();
        $conditions = [
            'employee_code' => trim($row['regi#']),
            'period' => Utility::formatPeriod($row['mthyrg'])
        ];
        $exists = Result::where($conditions)->exists();
        $data = array_merge($this->buildData($row), [
            'updated_at' => $timestamp,
        ]);
        
        if (!$exists) {
            $data['created_at'] = $timestamp;
        }
        return Result::updateOrInsert($conditions, $data);
    }

    public function import($headerFields, $rows){
        $returnValue = $this->traitImport($headerFields, $rows);
        //emit event to update user_position
        ProcessUserPosition::dispatch($returnValue['update']['data']);
        //emit event to update nissan_history
        ProcessHistorical::dispatch($returnValue['update']['data']);

        return $returnValue;
    }
}
