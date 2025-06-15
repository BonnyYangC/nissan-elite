<?php

namespace App\Services\DataMappingServices\ImportationImpl;

use App\Helper\Defination;

Trait ImportTrait {

  public function import($headerFields, $rows) {

    $resultValue = [];

    $updateCount = 0;
    $failedCount = 0;
    $failedRows = [];
    $ignoredCount = 0;
    $ignoredRows = [];
    $updatedRows = [];

    $modelKey = $this->getKeyForModel();
    $validationKey = $this->getKeyForValidate();

    foreach ($rows as $lineNumber => $row) {
        // $row = array_combine($headerFields, $row);

        if(!isset($row[$modelKey['primary']]) || !$this->isValidate($row, $validationKey)) {
            $failedCount++;
            $failedRows[] = $row;
            continue;
        }
        if (self::isIgnored($row, $validationKey)) {
            $ignoredCount++;
            $ignoredRows[] = $row;
            continue;
        }

        if ($this->importModel($row)) {
            $updateCount++;
            $updatedRows[] = $row;
        } else {
            $failedCount++;
            $failedRows[] = $row;
        }
    }
    $resultValue['type'] = Defination::ACTION_TYPE_SYNC;
    $resultValue['header'] = $headerFields;
    $resultValue['ignore']['count'] = 'Ignored: '.$ignoredCount;
    $resultValue['ignore']['data'] = $ignoredRows;
    $resultValue['wrong']['count'] = 'Failed: '.$failedCount;
    $resultValue['wrong']['data'] = $failedRows;
    $resultValue['update']['count'] = 'Synced: '.$updateCount;
    $resultValue['update']['data'] = $updatedRows;

    return $resultValue;
  }
}