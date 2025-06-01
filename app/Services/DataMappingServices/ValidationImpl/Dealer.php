<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Models\Dealer as DealerModel;
use App\Repositories\RegionRepository;
use App\Services\DataMappingServices\Dealer as BaseDealer;
use Illuminate\Support\Collection;

class Dealer extends BaseDealer {
    use ValidationTrait;

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
        //for dealer_regions table
        'region' => 'rname',
        'region_code' => 'rcode',
        'category' => 'dcat',
        'category_code' => 'dcat#'
    ];
    
    /** @var Collection */
    private $regions;

    public function __construct(RegionRepository $regionRepository) {
        Parent::__construct();
        $this->regions = $regionRepository->load();
    }

    /**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     * @return DealerModel
     */
    public function getModel($modelKey, $record) {
        return DealerModel::where('code', trim($record[$modelKey['primary']]))->with('regions')->first();
    }

    public function buildData($model, $row, $modelKey, $key){
        ini_set('max_execution_time', 180); //3 minutes
        
        $region = explode(' Region', $row['rname']);
        return array_merge(parent::buildData($model, $row, $modelKey, $key), [
            'region' => empty($region[0]) ? '' : $this->regions->filter(function($r) use ($row, $region) {return $r->title === $region[0];})->first()->code,
            'region_code' => $row['rcode'],
            'category' => $row['dcat'],
            'category_code' => $row['dcat#'],
            'active' => 1
        ]);
    }
    public function compareValue($field, $oldModel, $newValue) {
        $oldValue = isset($oldModel->$field) ? $oldModel->$field : data_get($oldModel->regions, $field, null);
        return $oldValue == $newValue ? true : false;
    }

    public function buildResultData($field, $oldModel, $newValue, $equal) {
        $result = [];
        $oldValue = isset($oldModel->$field) ? $oldModel->$field : data_get($oldModel->regions, $field, null);
        $result[$field] = $oldValue . ' / <span style="color:' . ($equal?'blue':'red') . ';">' . $newValue . '</span>';
        return $result;
    }
}
