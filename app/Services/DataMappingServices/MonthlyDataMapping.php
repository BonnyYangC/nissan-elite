<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Helper\Utility;
use App\Models\{Result, User};
use Carbon\Carbon;

abstract class MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [];
    /** @var array  */
    public $mappingArray = [
        'period' => 'mthyrg',
        'employee_code' => 'regi#',

        'train_online' => 'points_train_online',
        'train_competency' => 'points_train_competency',
        'train_mastery' => 'points_train_mastery',
        'train_pathway' => 'points_train_pathway',
        'train_bonus' => 'points_train_bonus',

        'registration' => 'points_registration',
        'excellence' => 'points_excellence',
        'incentive' => 'points_incentive',
        'adjustment' => 'points_adjust_',
        'credit_mtd' => 'POINTS_MTHLY_',
        'credit_ytd' => 'POINTS_YTD',
        'lifetime' => 'POINTS_ytd_historical',
    ];

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }


    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'regi#';
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $dataType
     * @param $modelKey
     * @param $record
     * @return Result
     */
    public function getModel($actionType, $dataType, $modelKey, $record, $key) {
        $model = Result::where('employee_code', trim($record[$modelKey['primary']]))
            ->where('period', Utility::formatPeriod($record['mthyrg']))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new Result();
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
        }
        return $model;
    }

    /**
     * built data map for data uploader
     *
     * @param $model
     * @param [string] $dataType
     * @param [array] $row
     * @param [array] $modelKey
     * @param [string] $key
     * @return array
     */
    public function buildData($model, $dataType, $row, $modelKey, $key){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            'period'        => Utility::formatPeriod($row['mthyrg']),
            'employee_code' =>$row['regi#'],
            'metrics' => $this->metricsMapping($row),

            'train_online'              =>$row['points_train_online'] !== '' ? $row['points_train_online'] : 0,
            'train_competency'   =>$row['points_train_competency'] !== '' ? $row['points_train_competency'] : 0,
            'train_mastery'         =>isset($row['points_train_mastery']) && $row['points_train_mastery'] !== '' ? $row['points_train_mastery'] : 0,
            'train_pathway'      =>$row['points_train_pathway'] !== '' ? $row['points_train_pathway'] : 0,
            'train_bonus'        =>isset($row['points_train_bonus']) && $row['points_train_bonus'] !== '' ? $row['points_train_bonus'] : 0,

            'registration'          =>$row['points_registration'] !== '' ? $row['points_registration'] : 0,
            'excellence'            =>$row['points_excellence'] !== '' ? $row['points_excellence'] : 0,
            'incentive'             =>$row['points_incentive'] !== '' ? $row['points_incentive'] : 0,
            'adjustment'            =>$row['points_adjust_'] !== '' ? $row['points_adjust_'] : 0,
            'credit_mtd'            =>$row['POINTS_MTHLY_'] !== '' ? $row['POINTS_MTHLY_'] : 0,
            'credit_ytd'            =>$row['POINTS_YTD'] !== '' ? $row['POINTS_YTD'] : 0,
            'lifetime'              =>$row['POINTS_ytd_historical'] !== '' ? $row['POINTS_ytd_historical'] : 0,

        ];
    }

    /**
     * @param $row
     * @return array
     */
    abstract protected function metricsMapping($row);

    /**
     * to see if this record is ignored
     *
     * @param $type
     * @param $value
     * @return bool
     */
    public static function isIgnored($type, $value) {
        $result = false;
        return $result;
    }

    /**
     * @param $field
     * @param $oldValue
     * @param $newValue
     * @return bool
     */
    public function compareValue($field, $oldValue, $newValue) {
        if ($field == 'metrics') {
            $result = !$oldValue || !empty(array_diff($oldValue, $newValue)) ? false : true;
        } else {
            $result = $oldValue == $newValue ? true : false;
        }
        return $result;
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
        if($field !== 'metrics') {
            $result[$field] = $oldValue . ' / <span style="color:' . ($equal?'blue':'red') . ';">' . $newValue . '</span>';
        } else {
            foreach( array_keys($this->metricsMappingArray) as $field) {
                $fieldName = $this->metricsMappingArray[$field];
                $result[$fieldName] = $oldValue[$field] . ' / <span style="color:' . ($equal ? 'blue' : 'red') . ';">' . $newValue[$field] . '</span>';
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
            $result[] = $this->mappingArray[$field];
        } else {
            foreach(array_keys($this->metricsMappingArray) as $field) {
                $result[] = $this->metricsMappingArray[$field];
            }
        }
        return $result;
    }

    /**
     * @param string $employeeCode
     * @return bool
     */
    public function validate(string $employeeCode) {
        $model = User::where('employee_code', $employeeCode)->first();
        return $model ? true : false;
    }
}
