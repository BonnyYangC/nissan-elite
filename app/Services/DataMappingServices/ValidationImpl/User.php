<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Services\DataMappingServices\User as BaseUser;
use App\Models\User as UserModel;

class User extends BaseUser {
    use ValidationTrait;

    /** @var array  */
    public $mappingArray = [
        'employee_code'=>'regi#_',
        'salutation'=>'n_title_',
        'firstname'=>'n_fname_trim_',
        'lastname'=>'n_sname_trim_',
        'date_birth'=>'date_birth',
        'mobile'=>'ph_mobile_',
        'email'=>'addr_email',
        'date_created'=>'date_created',
        'dealer_code'=>'dcode',
        'position_code'=> 'sp_',
        'dept'=>'dept_code',
        'active'=>'status',
        // if validate
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
     * @return UserModel
     */
    public function getModel($modelKey, $record) {
        return UserModel::where('employee_code',trim($record[$modelKey['primary']]))->with("eligible")->first();
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
            'salutation'=>$row['n_title_'],
            'firstname'=>$row['n_fname_trim_'],
            'lastname'=>$row['n_sname_trim_'],
            'date_birth'=>$row['date_birth'] ?date('Y-m-d',strtotime($row['date_birth'])): null,
            'mobile'=>$row['ph_mobile_'],
            'email'=>$row['addr_email'],
            'date_created'=>$row['date_created'] ? date('Y-m-d',strtotime($row['date_created'])) : null,
            'dealer_code'=>$row['dcode'] ? $row['dcode'] : null,
            'position_code'=> !($row['sp_'] === 'N/A' || $row['sp_'] === '') ? $row['sp_'] : null,
            'dept'=>$row['dept_code'],
            'active'=>$row['status'] === 'active' ? 1 : 0,
            // if validate
            'registered'=>$row['registered_'] === 'Registered' ? 1 : 0,
            'member'=>$row['elite_mbr'] === 'Y' ? 1: 0,
            'met_criteria' => $row['criteria_EOY_MET'] === 'YES' ? 1 : 0,
            'excellence_eligible' => $row['excellence_eligible'] === 'YES' ? 1: 0
        ];
    }

    /**
     * @param $field
     * @param $oldModel
     * @param $newValue
     * @return bool
     */
    public function compareValue($field, $oldModel, $newValue) {
        $oldValue = isset($oldModel->$field) ? $oldModel->$field : data_get($oldModel->eligible, $field, null);
        return $oldValue == $newValue ? true : false;
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
        $oldValue = isset($oldModel->$field) ? $oldModel->$field : data_get($oldModel->eligible, $field, null);
        $result[$field] = $oldValue . ' / <span style="color:' . ($equal?'blue':'red') . ';">' . $newValue . '</span>';
        return $result;
    }

   /**
    // * @param  \DateTimeInterface $date
     * @return string
     */
 //   protected function serializeDate(DataTimeInterface $date){

  //      return $date->format('Y-m-d');
  //  }
}
