<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Services\DataMappingServices\LoyaltyHistorical as BaseLoyaltyHistorical;
use App\Models\History;


class LoyaltyHistorical extends BaseLoyaltyHistorical {
    // use ValidationTrait;
/**
     * get model according data file type
     *
     * @param $modelKey
     * @param $record
     */
    public function getModel($modelKey, $record) {
        $model = History::where('member_id', trim($record[$modelKey['primary']]))->get();
            // ->where('period', trim($modelKey['mapping'][$key]))->first();       
        return $model;
    }

    public function compareRow($models, $newValue) {
        $model = $models->filter(function (History $value, int $key) use ($newValue) {
            return $value->period === $newValue['period'];
        })->first();
        if (!$model)
            return [false, null];
        return [true, $model];
    }

    public function buildResultRow(?History $oldModel, $newValue, $equal) {
        if ($oldModel) {
            return array_reduce(array_keys($newValue), function ($carry, $key) use ($oldModel, $newValue, $equal) {
                return data_set($carry, $key, $oldModel->$key . ' / <span style="color:' . ($equal ? 'blue' : 'red') . ';">' . $newValue[$key] . '</span>');
            }, []);
        } else {
            return array_reduce(array_keys($newValue), function ($carry, $key) use ($newValue) {
                return data_set($carry, $key, 'null' . ' / <span style="color:red;">' . $newValue[$key] . '</span>');
            }, []);
        }
    }
}