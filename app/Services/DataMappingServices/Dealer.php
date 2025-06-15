<?php

namespace App\Services\DataMappingServices;

use Illuminate\Support\Facades\Validator;

class Dealer extends Base {
    /** @var array  */
    public $mappingArray = [
        'code' => 'dcode',
        'name' => 'dname',
        'address' => 'addr_street',
        'suburb' => 'addr_city',
        'state' => 'addr_state',
        'postcode' => 'addr_pcode',
        'phone' => 'ph_tel',
        'fax' => 'ph_fax',
    ];

    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'dcode';
        // $key['primary'] = 'code'; use this to import dealer when 2022 elite system set up
        return $key;
    }

    public function isValidate(array $record, array $key): bool {
        $validator = Validator::make($record, [
            'dcode' => 'required|string',
            'dname' => 'required|string',
            'rcode' => 'required|string',
            'rname' => 'required|string',
            'deal~regi_rcode::rcode' => 'required|string',
            'dcat' => 'required|string',
            'dcat#' => 'required|string',
        ]);
        // dd($validator->errors()->all());
        return !$validator->fails();
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
    public function buildData($row){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            // 'code' => trim($row['dcode']),
            'name' => $row['dname'],
            'address' => $row['addr_street'],
            'suburb' => $row['addr_city'],
            'state' => trim($row['addr_state']),
            'postcode' => $row['addr_pcode'],
            // 'country' => $row['country'],
            'phone' => $row['ph_tel'],
            'fax' => $row['ph_fax'],
            'active' => 1  // as ie_dealer_data_xxx only contains active dealer
            // 'active' => $row['active'] !== 'NULL' ? $row['active'] : 0,
        ];
    }
}
