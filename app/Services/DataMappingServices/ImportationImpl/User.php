<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\User as BaseUser;
use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class User extends BaseUser {

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return UserModel
     */
    public function getModel($modelKey, $record, $key) {
        $model = UserModel::where('employee_code',trim($record[$modelKey['primary']]))->first();
        if(!$model){
            $model = new UserModel();
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
            $model->admin = 0;
            $model->password = Hash::make(strtoupper(trim($record['n_sname_trim_'])).'1');
        }
        return $model;
    }
}
