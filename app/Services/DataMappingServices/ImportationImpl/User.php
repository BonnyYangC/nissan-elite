<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Jobs\ProcessUserEligible;
use App\Services\DataMappingServices\User as BaseUser;
use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class User extends BaseUser {

    use ImportTrait {
        ImportTrait::import as traitImport; // alias
    }

    public function importModel($row) {
        $timestamp = Carbon::now();
        $conditions = [
            'employee_code' => trim($row['regi#_'])
        ];
        $exists = UserModel::where($conditions)->exists();
        $data = array_merge($this->buildData($row), [
            'updated_at' => $timestamp,
        ]);
        
        if (!$exists) {
            $data['admin'] = 0;
            $data['password'] = Hash::make(strtoupper(trim($row['n_sname_trim_'])) . '1');
            $data['created_at'] = $timestamp;
        }

        return UserModel::updateOrInsert($conditions, $data);
    }

    public function import($headerFields, $rows){
        $returnValue = $this->traitImport($headerFields, $rows);
        //emit event to update user_eligible
        ProcessUserEligible::dispatch($returnValue['update']['data']);

        return $returnValue;
    }

    private function buildData($row){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            // 'employee_code'=>$row['regi#_'],
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
            'active'=>($row['status'] === 'inactive' || $row['status'] === 'ineligible') ? 0 : 1
        ];
    }

}
