<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Helper\Utility;
use App\Models\Ranking as RankingModel;
use Carbon\Carbon;

class Base {
    /** @var array  */
    public $mappingArray = [];

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * to see if this record is ignored
     *
     * @param $value
     * @return bool
     */
    public static function isIgnored($value) {
        $result = false;
        return $result;
    }

    /**
     * @param string $employeeCode
     * @return bool
     */
    public function validate(string $employeeCode) {
        return true;
    }

    /**
     * @param $field
     * @param $oldValue
     * @param $newValue
     * @return bool
     */
    public function compareValue($field, $oldValue, $newValue) {
        return $oldValue && $oldValue == $newValue ? true : false;
    }

    /**
     * @param $field
     * @param $oldValue
     * @param $newValue
     * @param $equal
     * @return array
     */
    public function buildResultData($field, $oldValue, $newValue, $equal) {
        $result = [];
        $result[$field] = $oldValue . ' / <span style="color:' . ($equal?'blue':'red') . ';">' . $newValue . '</span>';
        return $result;
    }

    /**
     * @param $field
     * @return array
     */
    public function buildHeaderForResultData($field) {
        $result = [];
        $result[] = $this->mappingArray[$field];
        return $result;
    }
}
