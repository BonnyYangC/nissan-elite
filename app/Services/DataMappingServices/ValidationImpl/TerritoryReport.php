<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Helper\Defination;
use App\Services\DataMappingServices\TerritoryReport as BaseTerritoryReport;
use App\Models\TerritoryReport as TerritoryReportModel;

class TerritoryReport extends BaseTerritoryReport {
    use ValidationTrait, ValidateTrait;

    public function validateModel($row) {

        $conditions = [
            'employee_code' => trim($row['regi#_']), //$record[$modelKey['primary']])
        ];
        $existModel = TerritoryReportModel::where($conditions)->first();
        if (!$existModel)
            return [Defination::VALIDATION_STATUS_NEW, [$row], []];

        $newData = $this->buildData($row);
        $formattedRow = [];
        $headers = [];
        foreach ($newData as $fieldName => $value) {
            $equal = $this->compareValue($fieldName, $existModel, $value);
            $formattedRow = array_merge($formattedRow, $this->buildResultData($fieldName, $existModel, $value, $equal));
            $headers = array_merge($headers, $this->buildHeaderForResultData($fieldName));
        }
        return [Defination::VALIDATION_STATUS_FIND, [$formattedRow], $headers];
    }
}
