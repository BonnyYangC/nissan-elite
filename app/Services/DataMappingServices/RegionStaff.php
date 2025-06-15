<?php

namespace App\Services\DataMappingServices;

use App\Repositories\RegionRepository;
use Illuminate\Support\Collection;

class RegionStaff extends Base {
    /** @var array  */
    public $mappingArray = [
        'firstname' => 'Firstname',
        'lastname' => 'Surname',
        'position_code' => 'Position',
        'region_code' => 'Region',
        'email' => 'Email',
        'mobile' => 'Mobile',
        'active' => 'Active',
    ];
    
    /** @var Collection */
    private $regions;


    public function __construct(RegionRepository $regionRepository) {
        Parent::__construct();
        $this->regions = $regionRepository->load();
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
    public function buildData($row){
        ini_set('max_execution_time', 180); //3 minutes
        // list($firstName, $surName) = explode(' ', $row['full name']);
        return [
            'firstname' => $row[$this->mappingArray['firstname']],
            'lastname' => $row[$this->mappingArray['lastname']],
            'position_code' => strtoupper(trim($row[$this->mappingArray['position_code']])),
            'region_code' => $this->regions->first(function($r) use ($row) {return strtolower($r->title) === strtolower($row[$this->mappingArray['region_code']]);})->code,
            'email' => $row[$this->mappingArray['email']],
            'mobile' => data_get($row, $this->mappingArray['mobile'], null),
            'active' => $row[$this->mappingArray['active']] === 'YES' ? 1 : 0
        ];
    }
}
