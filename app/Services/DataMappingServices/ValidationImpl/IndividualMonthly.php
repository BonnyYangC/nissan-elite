<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Helper\Defination;
use App\Services\DataMappingServices\MonthlyDataMapping;
use App\Models\Result;
use App\Helper\Utility;

class IndividualMonthly extends MonthlyDataMapping {

    use ValidateTrait;

    public function validateModel($row) {

        $conditions = [
            'employee_code' => trim($row['regi#']),
            'period' => Utility::formatPeriod($row['mthyrg'])
        ];
        $existModel = Result::where($conditions)->first();
        if (!$existModel)
            return [Defination::VALIDATION_STATUS_NEW, [$row], []];

        $newData = $this->buildData($row);
        $formattedRow = [];
        $headers = [];
        foreach ($newData as $fieldName => $value) {
            $value = json_decode($value, true);
            $equal = $this->compareValue($fieldName, $existModel, $value);
            $formattedRow = array_merge($formattedRow, $this->buildResultData($fieldName, $existModel, $value, $equal));
            $headers = array_merge($headers, $this->buildHeaderForResultData($fieldName));
        }
        return [Defination::VALIDATION_STATUS_FIND, [$formattedRow], $headers];
    }

}
