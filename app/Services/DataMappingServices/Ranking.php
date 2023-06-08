<?php

namespace App\Services\DataMappingServices;

use App\Helper\Utility;

class Ranking extends Base {
    /** @var array  */
    public $mappingArray = [
        'period'        => 'mthyr_g_',
        'employee_code' =>'regi#_',
        'rank'          =>'rank_STATUS_',
        'total'         =>'yr_2023_status',
        'rank_platinum' =>'rank_PLATINUM_',
        'total_platinum'=>'yr_2023_platinum',
        'rank_state'    =>'state_rank_',
        'position'      =>'sp_',
    ];

    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'regi#_';
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
        $statusRank = isset($row['rank_STATUS_']) && isset($row['yr_2023_status']) ? [
            'rank' => $row['rank_STATUS_'] && $row['rank_STATUS_'] !== '' ? $row['rank_STATUS_'] : null,
            'total' => $row['yr_2023_status'] && $row['yr_2023_status'] !== '' ? $row['yr_2023_status'] : 0,
        ] : [];
        $platinumRank = isset($row['rank_PLATINUM_']) && isset($row['yr_2023_platinum']) ? [
            'rank_platinum' => $row['rank_PLATINUM_'] && $row['rank_PLATINUM_'] !== '' ? $row['rank_PLATINUM_'] : null,
            'total_platinum' => $row['yr_2023_platinum'] && $row['yr_2023_platinum'] !== '' ? $row['yr_2023_platinum'] : 0,
        ] : [];
        return array_merge([
            'period'        => Utility::formatPeriod($row['mthyr_g_']),
            'employee_code' =>$row['regi#_'],
            'rank_state'    =>$row['state_rank_'],
            'position'      =>$row['sp_'],
        ], $statusRank, $platinumRank);
    }
}
