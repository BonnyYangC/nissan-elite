<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\Base;
use App\Models\DealerRegion as DealerRegionModel;
use Illuminate\Support\Collection;


class DealerRegion extends Base {
    /** @var array  */
    public $mappingArray = [
        'code' => 'dcode',
        'region' => 'rname',
        'region_code' => 'rcode',
        'category' => 'dcat',
        'category_code' => 'dcat#'
    ];

    /** @var Collection */
    private $regions;

    public function __construct(Collection $regions) {
        Parent::__construct();
        $this->regions = $regions;
    }

    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'dcode';
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return DealerRegionModel
     */
    public function getModel($modelKey, $record, $key) {
        $model = DealerRegionModel::currentYear()
            ->where('code',trim($record[$modelKey['primary']]))
            ->first();
        if(!$model){
            $model = DealerRegionModel::factory()->make();
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
            'region' => empty($region[0]) ? '' : $this->regions->filter(function($r) use ($row, $region) {return $r->title === $region[0];})->first()->code,
            'region_code' => $row['rcode'],
            'category' => $row['dcat'],
            'category_code' => $row['dcat#'],
        ];
        
    }
}
