<?php

namespace App\Services\DataMappingServices\ValidationImpl;

use App\Helper\Defination;

Trait ValidateTrait {

  public function validate($headerFields, $rows) {

    $resultValue = [];

    $findCount = 0;
    $findRows = [];
    $newRowCount = 0;
    $newRows = [];
    $ignoredCount = 0;
    $ignoredRows = [];
    $wrongCount = 0;
    $wrongRows = [];

    $modelKey = $this->getKeyForModel();
    $validationKey = $this->getKeyForValidate();

    $headers = [];
    foreach ($rows as $lineNumber => $row) {

        // $row = array_combine($headerFields, $row);

        if(!isset($row[$modelKey['primary']]) || !$this->isValidate($row, $validationKey)) {
            $wrongCount++;
            $wrongRows[] = $row;
            continue;
        }
        if (self::isIgnored($row, $validationKey)) {
            $ignoredCount++;
            $ignoredRows[] = $row;
            continue;
        }
        [$status, $formattedRow, $headers] = $this->validateModel($row);
        switch ($status) {
            case Defination::VALIDATION_STATUS_NEW:
                $newRowCount++;
                $newRows = array_merge($newRows, $formattedRow);
                break;
            case Defination::VALIDATION_STATUS_FIND:
                $findCount++;
                $findRows = array_merge($findRows, $formattedRow);
                break;
            default:
                break;
        }
    }
    
    $resultValue['type'] = Defination::ACTION_TYPE_VALIDATE;
    $resultValue['wrong']['count'] = 'Wrong : (' . $wrongCount . ') ';
    if ($wrongCount) $resultValue['wrong']['count'] .= $this->getValidateMessage();
    $resultValue['wrong']['header'] = $wrongCount ? $headerFields : [];
    $resultValue['wrong']['data'] = $wrongRows;
    $resultValue['new']['count'] = 'New : ' . $newRowCount;
    $resultValue['new']['header'] = $newRowCount ? $headerFields : [];
    $resultValue['new']['data'] = $newRows;
    $resultValue['ignore']['count'] = 'Ignore : ' . $ignoredCount;
    $resultValue['ignore']['header'] = $ignoredCount ? $headerFields : [];
    $resultValue['ignore']['data'] = $ignoredRows;
    $resultValue['find']['count'] = 'Find : ' . $findCount;
    $resultValue['find']['header'] = $findCount ? $headers : [];
    $resultValue['find']['data'] = $findRows;

    return $resultValue;
  }
}