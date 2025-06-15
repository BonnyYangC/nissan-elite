<?php

namespace App\Services\DataMappingServices;

use Illuminate\Support\Facades\Validator;

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

    // implement Ignore interface
    public static function isIgnored(array $record, array $key): bool {
        return in_array($record[$key['dealer']], [55]);
    }

    // implement Ignore interface
    public function isValidate(array $record, array $key): bool {
        $validator = Validator::make($record, [
            'dcode' => 'required|string|exists:dealers,code'
        ]);
        return !$validator->fails();
    }
    public function getValidateMessage(): string {
        return 'Please check dealer/position exist or not!';
    }

    public function getKeyForValidate(): array {
        $key = [];
        $key['dealer'] = 'dcode';
        $key['position'] = 'sp_';
        return $key;
    }
}
