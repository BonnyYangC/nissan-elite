<?php

namespace App\Services\DataMappingServices;

use Illuminate\Support\Facades\Validator;

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
        //$key['mapping'] = [
        //     'yr_92_18_t_loyaltyAC_' => '2018-01-01',
        //     'yr_2019_' => '2019-01-01',
        //     'yr_2020_' => '2020-01-01',
        //     'yr_2021' => '2021-01-01',
        //     'yr_2022' => '2022-01-01',
        //     'yr_2023' => '2023-01-01',
        //     'yr_2024' => '2024-01-01'
        // ];
        $result = [
            'yr_92_18_t_loyaltyAC_' => '2018-01-01',
        ];

        for ($y = 2019; $y < config('app.theme'); $y++) {
            $suffix = ($y >= 2021) ? '' : '_'; // remove underscore from 2021 onward
            $k = "yr_{$y}{$suffix}";
            $value = "{$y}-01-01";
            $result[$k] = $value;
        }
        $key['mapping'] = $result;
        return $key;
    }

    public function isValidate(array $record, array $key): bool {
        $validator = Validator::make($record, [
            'regi#_' => 'required|string|exists:users,employee_code'
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
    public function buildData($row, $modelKey, $key){
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
        return ['member_id', 'period', 'amount'];
    }
}
