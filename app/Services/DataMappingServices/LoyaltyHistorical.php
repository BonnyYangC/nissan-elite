<?php

namespace App\Services\DataMappingServices;

class LoyaltyHistorical extends Base {

    /** @var array  */
    public $mappingArray = [
        'member_id' => 'regi#_',
    ];

    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'regi#_';
        //$key['secondary'] = ['yr_92_18_t_loyaltyAC_', 'yr_2019_', 'yr_2020_', 'yr_2021'];
        $key['mapping'] = [
            'yr_92_18_t_loyaltyAC_' => '2018-01-01',
            'yr_2019_' => '2019-01-01',
            'yr_2020_' => '2020-01-01',
            'yr_2021' => '2021-01-01',
            'yr_2022' => '2022-01-01'
        ];
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
            'member_id' => $row['regi#_'],
            'period'    => $modelKey['mapping'][$key],
            'amount'    => isset($row[$key]) && $row[$key] !== '' ? $row[$key] : 0.0
        ];
    }


    /**
     * @param $field
     * @return array
     */
    public function buildHeaderForResultData($field) {
        $result = [];
        /*if($field !== 'metrics') {
            $result[] = $this->$mappingArray[$field];
        } else {
            foreach(array_keys($this->metricsMappingArray) as $field) {
                $result[] = $this->metricsMappingArray[$field];
            }
        }*/
        return $result;
    }
}
