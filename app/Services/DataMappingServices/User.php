<?php

namespace App\Services\DataMappingServices;

class User extends Base {
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
        'active'=>'status'
    ];

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
            'date_birth'=>$row['date_birth']?date('Y-m-d',strtotime($row['date_birth'])): null,
            'mobile'=>$row['ph_mobile_'],
            'email'=>$row['addr_email'],
            'date_created'=>$row['date_created'] ? date('Y-m-d',strtotime($row['date_created'])) : null,
            'dealer_code'=>$row['dcode'] ? $row['dcode'] : null,
            'position_code'=> !($row['sp_'] === 'N/A' || $row['sp_'] === '') ? $row['sp_'] : null,
            'dept'=>$row['dept_code'],
            'active'=>$row['status'] === 'active' ? 1 : 0
        ];
    }
}
