<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
