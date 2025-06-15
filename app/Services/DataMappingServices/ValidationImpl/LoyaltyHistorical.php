<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Helper\Defination;
use App\Services\DataMappingServices\LoyaltyHistorical as BaseLoyaltyHistorical;
use App\Models\History;

class LoyaltyHistorical extends BaseLoyaltyHistorical {
    // use ValidationTrait;
    use ValidateTrait;

    public function validateModel($row) {
        $findRows = [];
        $newRows = [];
        $formattedRow = [];
        $headers = [];
        $conditions = [
            'member_id' => trim($row['regi#_'])
        ];
        $existModels = History::where($conditions)->get();

        $modelKey = $this->getKeyForModel();
        $status = collect(array_keys($modelKey['mapping']))->map(function ($key) use ($row, $modelKey, $findRows, $newRows, $formattedRow, $existModels) {
            $newData = $this->buildData($row, $modelKey, $key);
            list($equal, $matchedModel) = $this->compareRow($existModels, $newData);
            if ($matchedModel) {
                $formattedRow = array_merge($formattedRow, $this->buildResultRow($matchedModel, $newData, $equal));
                $findRows[] = $formattedRow;
                return true;
            } else {
                $formattedRow = array_merge($formattedRow, $this->buildResultRow($matchedModel, $newData, $equal));
                $newRows[] = $formattedRow;
                return false;
            }
        })->filter(function ($result) {
            return $result === false; })->count() === 0;
        $headers = array_merge($headers, $this->buildHeaderForResultData($existModels[0]));
        return $status ? [Defination::VALIDATION_STATUS_FIND, $findRows, $headers] : [Defination::VALIDATION_STATUS_NEW, $newRows, $headers];
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