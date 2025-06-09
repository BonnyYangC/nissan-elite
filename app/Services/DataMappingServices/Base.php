<?php

namespace App\Services\DataMappingServices;

use App\Services\DataMappingServices\Interfaces\{Ignore, Valid};

class Base implements Ignore, Valid {
    /** @var array  */
    public $mappingArray = [];
    
    public function __construct() { }

    // implement Ignore interface
    public static function isIgnored(array $record, array $key): bool {
        return false;
    }

    // implement Valid interface
    public function isValidate(array $record, array $key): bool {
        return true;
    }
    
    public function getKeyForValidate(): array {
        $key = [];
        $key['employee'] = 'regi#_';
        return $key;
    }

    public function getValidateMessage(): string {
        return '';
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
