<?php

namespace App\Services\DataMappingServices;

use App\Helper\Utility;
use App\Models\UserPositions;

class Ranking extends Base {
    /** @var array  */
    public $mappingArray = [
        'period'        => 'mthyr_g_',
        'employee_code' =>'regi#_',
        'rank'          =>'rank_STATUS_',
        'total'         =>'yr_2025_status',
        'rank_platinum' =>'rank_PLATINUM_',
        'total_platinum'=>'yr_2025_platinum_',
        'rank_state'    =>'state_rank_',
        'position'      =>'sp_',
    ];

    private $hasRanking = false;
    private $hasPlatinumRanking = false;

    public function isValidate(array $record, array $key): bool {
        $hasUserPosition = UserPositions::where('employee_code', $record[$key['employ']])->where('position_code', $record[$key['position']])->first();
        $this->hasRanking = isset($record[$this->mappingArray['rank']]) && isset($record[$this->mappingArray['total']]);
        $this->hasPlatinumRanking = isset($record[$this->mappingArray['rank_platinum']]) && isset($record[$this->mappingArray['total_platinum']]);
        return $hasUserPosition && ($this->hasRanking || $this->hasPlatinumRanking) ? true : false;
    }

    public function getValidateMessage(): string {
        return 'Please check employee/position exist or not!';
    }

    public function getKeyForValidate(): array {
        $key = [];
        $key['employ'] = 'regi#_';
        $key['position'] = 'sp_';
        return $key;
    }

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

    public function buildData($row){
        ini_set('max_execution_time', 180); //3 minutes
        $statusRank = $this->hasRanking ? [
            'rank' => Utility::getArrayAttribute($row, $this->mappingArray['rank'], null),
            'total' => Utility::getArrayAttribute($row, $this->mappingArray['total'], 0),
        ] : [];
        $platinumRank = $this->hasPlatinumRanking ? [
            'rank_platinum' => Utility::getArrayAttribute($row, $this->mappingArray['rank_platinum'], null),
            'total_platinum' => Utility::getArrayAttribute($row, $this->mappingArray['total_platinum'], 0),
        ] : [];
        return array_merge([
            // 'period'        => Utility::formatPeriod($row[$this->mappingArray['period']]),
            // 'employee_code' =>$row[$this->mappingArray['employee_code']],
            'rank_state'    =>$row[$this->mappingArray['rank_state']],
            'position'      =>$row[$this->mappingArray['position']],
        ], $statusRank, $platinumRank);
    }
}