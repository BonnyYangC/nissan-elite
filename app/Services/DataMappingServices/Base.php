<?php

namespace App\Services\DataMappingServices;

class Base {
    /** @var array  */
    public $mappingArray = [];

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * to see if this record is ignored
     *
     * @param $value
     * @return bool
     */
    public static function isIgnored($value) {
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
    
    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'regi#_';
        //$key['primary'] = 'employee_code'; // use this for import users from elite-2022-users.csv when elite 2022 system setup
        return $key;
    }

    public function getHeaderField($field) {
        return data_get($this->mappingArray, $field, null);
    }
}
