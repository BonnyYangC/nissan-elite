<?php

namespace App\Services\DataMappingServices;

use Illuminate\Support\Collection;

class RegionStaff extends Base {
    /** @var array  */
    public $mappingArray = [
        'firstname' => 'First Name',
        'lastname' => 'Sur Name',
        'position_code' => 'Position',
        'region_code' => 'Region',
        'email' => 'Email',
        'mobile' => 'Mobile',
        'active' => 'Active',
    ];
    
    /** @var Collection */
    private $regions;

    /**
     * RegionStaff constructor.
     * @param Collection $regions
     */
    public function __construct(Collection $regions) {
        Parent::__construct();
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
        // list($firstName, $surName) = explode(' ', $row['full name']);
        return [
            'firstname' => $row['first name'],
            'lastname' => $row['last name'],
            'position_code' => $row['Position'],
            'region_code' => $this->regions->filter(function($r) use ($row) {return strtoupper($r->title) === $row['Region'];})->first()->code,
            'email' => $row['Email'],
            'mobile' => data_get($row, 'Mobile', null),
            'active' => $row['active'] === 'YES' ? 1 : 0
        ];
    }
}
