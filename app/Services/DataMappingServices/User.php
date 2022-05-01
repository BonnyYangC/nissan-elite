<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class User {

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
        // $key = 'n_sname_trim_';  // this is for generate password
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $dataType
     * @param $modelKey
     * @param $record
     * @return UserModel
     */
    public function getModel($actionType, $dataType, $modelKey, $record, $key) {
        $model = UserModel::where('employee_code',trim($record[$modelKey['primary']]))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new UserModel();
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
            $model->admin = 0;
            $model->password = Hash::make(strtoupper(trim($record['n_sname_trim_'])).'1');
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
            'employee_code'=>$row['regi#_'],
            'salutation'=>$row['n_title_'],
            'firstname'=>$row['n_fname_trim_'],
            'lastname'=>$row['n_sname_trim_'],
            'date_birth'=>$row['date_birth'] ? $row['date_birth'] : null,
            'mobile'=>$row['ph_mobile_'],
            'email'=>$row['addr_email'],
            // 'password' => bcrypt(strtoupper($row['n_sname_trim_']).'1'),
            'date_created'=>$row['date_created'] ? $row['date_created'] : null,
            'dealer_code'=>$row['dcode'] ? $row['dcode'] : null,
            'position_code'=> !($row['sp_'] === 'N/A' || $row['sp_'] === '') ? $row['sp_'] : null,
            'dept'=>$row['dept_code'],
            'active'=>$row['status'] === 'active' ? 1 : 0,
            'registered'=>$row['registered_'] === 'Registered' ? 1 : 0,
            'member'=>$row['elite_mbr'] === 'Y' ? 1: 0,
            'met_criteria' => $row['criteria_met_EOY'] === 'No' ? 0 : 1,
            'excellence_eligible' => $row['excellence_eligible'] === 'YES' ? 1: 0
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
