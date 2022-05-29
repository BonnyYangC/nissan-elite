<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class RegionStaff {

    private $regions;

    /**
     * RegionStaff constructor.
     * @param Collection $regions
     */
    public function __construct(Collection $regions) {
        $this->regions = $regions;
    }


    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'Email';
        //$key['primary'] = 'email'; /*use this for import regional staff from elite-2021-regional-staff.csv when elite 2022 system setup*/
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $dataType
     * @param $modelKey
     * @param $record
     * @return User
     */
    public function getModel($actionType, $dataType, $modelKey, $record, $key) {
        $model = User::where('email',trim($record[$modelKey['primary']]))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new User();
            // $model->employee_code = null;
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
            $model->admin = 0;
            $model->password = bcrypt(strtoupper(trim($record['sName'])).'1');
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
            'firstname' => $row['fName'],
            'lastname' => $row['sName'],
            'position_code' => $row['Position'],
            'region_code' => $this->regions->filter(function($r) use ($row) {return strtoupper($r->title) === $row['Region'];})->first()->code,
            'email' => $row['Email'],
            'mobile' => $row['Mobile'] ? $row['Mobile'] : null,
            'active' => $row['Active'] === 'YES' ? 1 : 0
        ];

        /*use this for import regional staff from elite-2021-regional-staff.csv when elite 2022 system setup*/
        /*$region = $this->regions->filter(function($r) use ($row) {return strtoupper($r->title) === $row['alt_position'];})->first();
        return [
            'salutation'=>$row['salutation'],
            'firstname'=>$row['firstname'],
            'lastname'=>$row['lastname'],

            'position_code'=> !($row['position'] === 'N/A' || $row['position'] === '') ? $row['position'] : null,
            'region_code' => $region && isset($region['code']) ? $region['code'] : null,

            'date_birth'=>!($row['dob'] == '0000-00-00' || $row['dob'] == 'NULL') ? $row['dob'] : null,
            'mobile'=>$row['mobile'],
            'email'=>$row['email'],
            'password' => Hash::make(strtoupper(trim($row['lastname'])).'1'),
            'date_created'=>!($row['date_created'] == 'NULL') ? $row['date_created'] : null,
            'dealer_code'=>!($row['company_code'] == 'NULL') ? $row['company_code'] : null,
            'dept'=>$row['dept'],
            'active'=>$row['active'],
            'registered'=>!($row['registered'] == 'NULL') ? $row['registered'] : 0,
            'member'=>!($row['member'] == 'NULL') ? $row['member'] : 0,
            'met_criteria' => !($row['met_criteria'] == 'NULL') ? $row['met_criteria'] : 0,
            'excellence_eligible' => !($row['excellence_eligible'] == 'NULL') ? $row['excellence_eligible'] : 0
        ];*/
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
}
