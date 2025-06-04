<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Models\User;
use App\Services\DataMappingServices\Base;
use App\Models\UserPositions as UserPositionsModel;


class UserPositions extends Base {
    /** @var array  */
    public $mappingArray = [
        'employee_code' => 'regi#_',
        'position_code' => 'sp_',
        // 'position_code' => 'sp_techcert'
    ];

    // implement Valid interface
    public static function isValidate(array $record, array $key): bool {
        $position = trim($record[$key['position']]) !== 'N/A';
        $user = User::where('employee_code',trim($record[$key['employee']]))->first();
        return $position && $user ? true : false;
    }
    
    public function getKeyForValidate(): array {
        $key = [];
        $key['employee'] = 'regi#_';
        $key['position'] = 'sp_';
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return UserPositionsModel | null
     */
    public function getModel($modelKey, $record, $key) {
        $model = UserPositionsModel::where('employee_code',trim($record[$modelKey['primary']]))
            ->where('position_code',trim($record['sp_']))
            ->first();
        if(!$model){
            $model = UserPositionsModel::factory()->make();
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
            'employee_code'=>$row[$this->mappingArray['employee_code']],
            // 'position_code'=> !($row['sp_'] === 'N/A' || $row['sp_'] === '') ? $row['sp_'] : null,
            'position_code'=> !($row[$this->mappingArray['position_code']] === 'N/A' || $row[$this->mappingArray['position_code']] === '') ? $row[$this->mappingArray['position_code']] : null,
        ];
        
    }
}
