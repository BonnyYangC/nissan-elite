<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Services\DataMappingServices\LoyaltyHistorical as BaseLoyaltyHistorical;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoyaltyHistorical extends BaseLoyaltyHistorical {

    use ImportTrait;

    public function importModel($row) {
        $connect = DB::connection('mysql_nissan');
        $modelKey = $this->getKeyForModel();
        return collect(array_keys($modelKey['mapping']))->map(function ($key) use ($row, $modelKey, $connect) {
            $timestamp = Carbon::now();
            $conditions = [
                'member_id' => trim($row['regi#_']),
                'period' => $modelKey['mapping'][$key]
            ];
            $exists = History::where($conditions)->exists();
            $data = array_merge($this->buildData($row, $modelKey, $key), [
                'updated_at' => $timestamp,
            ]);

            if (!$exists) {
                $data['created_at'] = $timestamp;
            }
            return $connect->table((new History())->getTable())->updateOrInsert($conditions, $data);
        })->filter(function ($result) {
            return $result === false; })->count() === 0;
    }
}