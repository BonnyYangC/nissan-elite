<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Models\Result;
use App\Helper\Utility;

trait MonthlyValidationTrait {
    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $modelKey
     * @param $record
     * @return Result
     */
    public function getModelForValidation($modelKey, $record, $key) {
        $model = Result::where('employee_code', trim($record[$modelKey['primary']]))
            ->where('period', Utility::formatPeriod($record['mthyrg']))->first();
        return $model;
    }

    /**
     * @param $field
     * @param $model
     * @param $newValue
     * @return bool
     */
    public function compareValue($field, $model, $newValue) {
        $oldValue = $model -> $field;
        if ($field == 'metrics') {
            $result = !$oldValue || !empty(array_diff($oldValue, $newValue)) ? false : true;
        } else {
            $result = $oldValue == $newValue ? true : false;
        }
        return $result;
    }

    /**
     * @param $field
     * @param $model
     * @param $newValue
     * @param $equal
     * @return array
     */
    public function buildResultData($field, $model, $newValue, $equal) {
        $result = [];
        $oldValue = $model->$field;
        if($field !== 'metrics') {
            $result[$field] = $oldValue . ' / <span style="color:' . ($equal?'blue':'red') . ';">' . $newValue . '</span>';
        } else {
            foreach( array_keys($this->metricsMappingArray) as $field) {
                $fieldName = $this->metricsMappingArray[$field];
                $result[$fieldName] = data_get($oldValue, $field, '') . ' / <span style="color:' . ($equal ? 'blue' : 'red') . ';">' . $newValue[$field] . '</span>';
            }
        }
        return $result;
    }

    /**
     * @param $field
     * @return array
     */
    public function buildHeaderForResultData($field) {
        $result = [];
        if($field !== 'metrics') {
            $result[] = $this->getHeaderField($field);
        } else {
            foreach(array_keys($this->metricsMappingArray) as $field) {
                $result[] = $this->metricsMappingArray[$field];
            }
        }
        return $result;
    }

    public function getHeaderField($field) {
        return data_get($this->mappingArray, $field, null);
    }

}
