<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Helper\Utility;
use App\Services\DataMappingServices\Ranking as BaseRanking;
use App\Models\Ranking as RankingModel;
use Carbon\Carbon;

class Ranking extends BaseRanking {

    use ImportTrait;

    public function importModel($row) {
        $timestamp = Carbon::now();
        $conditions = [
            'employee_code' => trim($row['regi#_']),
            'period' => Utility::formatPeriod($row['mthyr_g_'])
        ];
        $exists = RankingModel::where($conditions)->exists();
        $data = array_merge($this->buildData($row), [
            'updated_at' => $timestamp,
        ]);
        
        if (!$exists) {
            $data['created_at'] = $timestamp;
        }

        return RankingModel::updateOrInsert($conditions, $data);
    }
}
