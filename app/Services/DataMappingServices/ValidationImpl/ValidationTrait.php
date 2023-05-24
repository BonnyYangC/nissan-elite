<?php

namespace App\Services\DataMappingServices\ValidationImpl;

trait ValidationTrait {

    /**
     * @param $field
     * @param $oldModel
     * @param $newValue
     * @return bool
     */
    public function compareValue($field, $oldModel, $newValue) {
        $oldValue = $oldModel->$field;
        return $oldValue && $oldValue == $newValue ? true : false;
    }

    /**
     * @param $field
     * @param $oldModel
     * @param $newValue
     * @param $equal
     * @return array
     */
    public function buildResultData($field, $oldModel, $newValue, $equal) {
        $result = [];
        $oldValue = $oldModel->$field;
        $result[$field] = $oldValue . ' / <span style="color:' . ($equal?'blue':'red') . ';">' . $newValue . '</span>';
        return $result;
    }

    /**
     * @param $field
     * @return array
     */
    public function buildHeaderForResultData($field) {
        $result = [];
        if ($field) {
            $result[] = $field;
        }
        return $result;
    }
}
