<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Models\Dealer as DealerModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
        'region' => 'rname',
        'region_code' => 'rcode',
        'category' => 'dcat',
        'category_code' => 'dcat#'
    ];
    /** @var Collection */
    private $regions;

    /**
     * Dealer constructor.
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
        $key['primary'] = 'dcode';
        // $key['primary'] = 'code'; use this to import dealer when 2022 elite system set up
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $modelKey
     * @param $record
     * @return DealerModel
     */
    public function getModel($actionType, $modelKey, $record, $key) {
        $model = DealerModel::where('code', trim($record[$modelKey['primary']]))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new DealerModel();
            $model->parent_id = 1;
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
        }
        return $model;
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
        $region = explode(' Region', $row['rname']);
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
            'region' => empty($region[0]) ? '' : $this->regions->filter(function($r) use ($row, $region) {return $r->title === $region[0];})->first()->code,
            'region_code' => $row['rcode'],
            'category' => $row['dcat'],
            'category_code' => $row['dcat#'],
            // 'active' => $row['active'] !== 'NULL' ? $row['active'] : 0,
        ];


/* use this to import dealer from elite-2021-dealer.csv when elite 2022 system setup
        return [
        'code' => $row['code'],
        'name' => $row['name'],
        'address' => $row['address'],
        'suburb' => $row['suburb'],
        'state' => $row['state'],
        'postcode' => $row['postcode'],
        'country' => $row['country'],
        'phone' => $row['phone'],
        'fax' => $row['fax'],
        'region' => $row['region'],
        'region_code' => $row['region_code'],
        'category' => $row['category'],
        'category_code' => $row['category_code'],
        'active' => $row['active'] !== 'NULL' ? $row['active'] : 0,
]; */
    }
}
