<?php

namespace App\Services\DataMappingServices;

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
            'code' => trim($row['dcode']),
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
