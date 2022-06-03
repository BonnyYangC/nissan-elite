<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Helper\Utility;
use App\Models\Ranking as RankingModel;
use Carbon\Carbon;

class Ranking {
    /** @var array  */
    public $mappingArray = [
        'period'        => 'mthyr_g_',
        'employee_code' =>'regi#_',
        'rank'          =>'rank_STATUS_',
        'total'         =>'yr_2022_status_',
        'rank_platinum' =>'rank_PLATINUM_',
        'total_platinum'=>'yr_2022_platinum_',
        'rank_state'    =>'state_rank_',
        'position'      =>'sp_',
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
        $key['primary'] = 'regi#_';
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $dataType
     * @param $modelKey
     * @param $record
     * @return RankingModel
     */
    public function getModel($actionType, $dataType, $modelKey, $record, $key) {
        $model = RankingModel::where('employee_code', trim($record[$modelKey['primary']]))
            ->where('period', Utility::formatPeriod($record['mthyr_g_']))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new RankingModel();
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
            'period'        => Utility::formatPeriod($row['mthyr_g_']),
            'employee_code' =>$row['regi#_'],
            'rank'          =>isset($row['rank_STATUS_']) && !empty($row['rank_STATUS_']) ? $row['rank_STATUS_'] : $model->rank,
            'total'         =>isset($row['yr_2022_status_']) && !empty($row['yr_2022_status_']) ? $row['yr_2022_status_'] : $model->total,
            'rank_platinum' =>isset($row['rank_PLATINUM_']) && !empty($row['rank_PLATINUM_']) ? $row['rank_PLATINUM_'] : $model->rank_platinum,
            'total_platinum'=>isset($row['yr_2022_platinum_']) && !empty($row['yr_2022_platinum_']) ? $row['yr_2022_platinum_'] : $model->total_platinum,
            'rank_state'    =>$row['state_rank_'],
            'position'      =>$row['sp_'],

            /*'dealer_code'   =>'dcode',//'d_code',
            'category'      =>'dcat',//'d_cat',
            'region_code'   =>'rcode',//'r_code',  //it's in the company table
            'registered'    =>'registered',*/
        ];
    }

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
        return $oldValue == $newValue ? true : false;
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
