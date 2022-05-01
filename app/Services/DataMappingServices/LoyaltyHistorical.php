<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Models\History;

class LoyaltyHistorical {

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
        //$key['secondary'] = ['yr_92_18_t_loyaltyAC_', 'yr_2019_', 'yr_2020_', 'yr_2021_'];
        $key['mapping'] = [
            'yr_92_18_t_loyaltyAC_' => '2018-01-01',
            'yr_2019_' => '2019-01-01',
            'yr_2020_' => '2020-01-01',
            'yr_2021_' => '2021-01-01'
        ];
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $dataType
     * @param $modelKey
     * @param $record
     * @return History
     */
    public function getModel($actionType, $dataType, $modelKey, $record, $key) {
        $model = History::where('member_id', trim($record[$modelKey['primary']]))
            ->where('period', trim($modelKey['mapping'][$key]))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new History();
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
            'member_id' => $row['regi#_'],
            'period'    => $modelKey['mapping'][$key],
            'amount'    => isset($row[$key]) && $row[$key] !== '' ? $row[$key] : 0.0
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

}
