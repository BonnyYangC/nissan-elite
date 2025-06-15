<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Helper\{Defination, Utility};
use App\Services\DataMappingServices\Ranking as BaseRanking;
use App\Models\Ranking as RankingModel;

class Ranking extends BaseRanking {
    use ValidationTrait, ValidateTrait;

    public function validateModel($row) {

        $conditions = [
            'employee_code' => trim($row['regi#_']),
            'period' => Utility::formatPeriod($row['mthyr_g_'])
        ];
        $existModel = RankingModel::where($conditions)->first();
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
