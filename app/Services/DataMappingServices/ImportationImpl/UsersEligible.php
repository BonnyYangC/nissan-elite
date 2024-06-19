<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\Base;
use App\Models\UsersEligible as UsersEligibleModel;


class UsersEligible extends Base {
    /** @var array  */
    public $mappingArray = [
        'employee_code'=>'regi#_',
        'registered'=>'registered_',
        'member'=>'elite_mbr',
        'met_criteria' => 'criteria_EOY_MET',
        'excellence_eligible' => 'excellence_eligible',
    ];

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return UsersEligibleModel
     */
    public function getModel($modelKey, $record, $key) {
        $model = UsersEligibleModel::currentYear()
            ->where('employee_code',trim($record[$modelKey['primary']]))
            ->first();
        if(!$model){
            $model = UsersEligibleModel::factory()->make();
        }
        return $model;
    }

    /**
     * built data map for data uploader
     *
     * @param $model
     * @param [array] $row
     * @param [array] $modelKey
     * @param [string] $key
     * @return array
     */
    public function buildData($model, $row, $modelKey, $key){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            'employee_code'=>$row['regi#_'],
            'registered'=>$row['registered_'] === 'Registered' ? 1 : 0,
            'member'=>$row['elite_mbr'] === 'Y' ? 1: 0,
            'met_criteria' => $row['criteria_EOY_MET'] === 'YES' ? 1 : 0,
            'excellence_eligible' => $row['excellence_eligible'] === 'YES' ? 1: 0
        ];
        
    }
}
