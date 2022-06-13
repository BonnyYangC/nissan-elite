<?php

namespace App\Services;

use App\Helper\Defination;
use App\Helper\Role;
use App\Services\DataMappingServices as DMS;
use App\Services\ExportServices\Admin;
use App\Services\ExportServices\LoyaltyHistorical;
use App\Services\ExportServices\RegionStaff;
use App\Services\ExportServices\TerritoryReport;
use App\Services\ExportServices\User;
use App\Services\ExportServices\Ranking;
use League\Csv\Reader;
use League\Csv\Statement;

class DataService extends BaseService {

    /**
     * @return mixed
     */
    public function getPositions() {
        return $this->serviceResolver->positionService()->load();
    }

    /**
     * @param $dataFile
     * @param $dataType
     * @return array
     * @throws \League\Csv\Exception
     * @throws \League\Csv\UnableToProcessCsv
     */
    public function importation($dataFile, $dataType) {

        $resultValue = [];
        $updateCount = 0;
        $failCount = 0;
        $ignoredCount = 0;

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);

            $mappingService = $this->getMappingService($dataType);
            $modelKey = $mappingService->getKeyForModel();

            foreach ($records as $lineNumber => $record) {

                if(!isset($record[$modelKey['primary']]) || !$mappingService->validate(trim($record[$modelKey['primary']]))) {
                    $failCount++;
                    continue;
                }
                if ($mappingService::isIgnored($record[$modelKey['primary']])) {
                    $ignoredCount++;
                    continue;
                }
                if (isset($modelKey['mapping'])) {
                    $keys = array_keys($modelKey['mapping']);
                } else {
                    $keys = [$modelKey['primary']];
                }
                foreach($keys as $key) {
                    $model = $mappingService->getModel(Defination::ACTION_TYPE_SYNC, $modelKey, $record, $key);

                    if ($model) {
                        $data = $mappingService->buildData($model, $record, $modelKey, $key);
                        foreach ($data as $fieldName => $value) {
                            $model->$fieldName = $value == '-' ? 0 : $value;
                        }
                        if ($model->save()) {
                            $updateCount++;
                        } else {
                            $failCount++;
                        }
                    }
                }
            }
            $resultValue['type'] = Defination::ACTION_TYPE_SYNC;
            $resultValue['update'] = $updateCount;
            $resultValue['ignore'] = $ignoredCount;
            $resultValue['wrong'] = $failCount;
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }

        return $resultValue;
    }

    /**
     * @param $dataFile
     * @param $dataType
     * @return array
     * @throws \League\Csv\Exception
     * @throws \League\Csv\UnableToProcessCsv
     */
    public function validation($dataFile, $dataType) {
        $resultValue = [];
        $findCount = 0;
        $findRows = [];
        $newRowCount = 0;
        $newRows = [];
        $ignoredCount = 0;
        $ignoredRows = [];
        $wrongCount = 0;
        $wrongRows = [];
        $headerFields = [];

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');

            $headerFields = $csvReader->fetchOne(0);
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);
            $mappingService = $this->getMappingService($dataType);
            $modelKey = $mappingService->getKeyForModel();

            foreach ($records as $lineNumber => $record) {

                if(!isset($record[$modelKey['primary']]) || !$mappingService->validate(trim($record[$modelKey['primary']]))) {
                    $wrongCount++;
                    $wrongRows[] = $record;
                    continue;
                }
                if ($mappingService::isIgnored($record[$modelKey['primary']])) {
                    $ignoredCount++;
                    $ignoredRows[] = $record;
                    continue;
                }
                if (isset($modelKey['mapping'])) {
                    $keys = array_keys($modelKey['mapping']);
                } else {
                    $keys = [$modelKey['primary']];
                }
                $row = [];
                $headers = [];
                foreach($keys as $key) {
                    $model = $mappingService->getModel(Defination::ACTION_TYPE_VALIDATE, $modelKey, $record, $key);
                    if($model){
                        $data = $mappingService->buildData($model, $record, $modelKey, $key);
                        foreach ($data as $fieldName => $value) {
                            $equal = $mappingService->compareValue($fieldName, $model->$fieldName, $value);
                            $row = array_merge($row, $mappingService->buildResultData($fieldName, $model->$fieldName, $value, $equal));
                            $headers = array_merge($headers, $mappingService->buildHeaderForResultData($fieldName));
                        }
                        $findCount++;
                        $findRows[] = $row;
                    }else{
                        $newRowCount++;
                        $newRows[] = $record;
                    }

                }
            }
            $resultValue['type'] = Defination::ACTION_TYPE_VALIDATE;
            $resultValue['new']['count'] = 'New : ' . $newRowCount;
            $resultValue['new']['header'] = $newRowCount ? $headerFields : [];
            $resultValue['new']['data'] = $newRows;
            $resultValue['ignore']['count'] = 'Ignore : ' . $ignoredCount;
            $resultValue['ignore']['header'] = $ignoredCount ? $headerFields : [];
            $resultValue['ignore']['data'] = $ignoredRows;
            $resultValue['wrong']['count'] = 'Wrong : ' . $wrongCount;
            $resultValue['wrong']['header'] = $wrongCount ? $headerFields : [];
            $resultValue['wrong']['data'] = $wrongRows;
            $resultValue['find']['count'] = 'Find : ' . $findCount;
            $resultValue['find']['header'] = $findCount ? $headers : [];
            $resultValue['find']['data'] = $findRows;
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }

        return $resultValue;
    }

    /**
     * @param $type
     * @return DMS\Dealer|DMS\FI|DMS\FleetSalesExecutives|DMS\LoyaltyHistorical|DMS\PartsManager|DMS\PartsSalesRep|DMS\Ranking|DMS\RegionStaff|DMS\RetailSalesConsultants|DMS\SalesManager|DMS\ServiceAdviser|DMS\ServiceManager|DMS\StockController|DMS\TerritoryReport|DMS\User
     */
    private function getMappingService($type) {
        switch ($type) {
            case Role::FLEET_SALES_EXECUTIVES:
                return new DMS\FleetSalesExecutives();
            case Role::SALES_MANAGER:
                return new DMS\SalesManager();
            case Role::RETAIL_SALES_CONSULTANTS:
                return new DMS\RetailSalesConsultants();
            case Role::STOCK_CONTROLLER:
                return new DMS\StockController();
            case Role::FI:
                return new DMS\FI();
            case Role::PARTS_MANAGER:
                return new DMS\PartsManager();
            case Role::PARTS_SALES_REP:
                return new DMS\PartsSalesRep();
            case Role::SERVICE_MANAGER:
                return new DMS\ServiceManager();
            case Role::SERVICE_ADVISERS:
                return new DMS\ServiceAdviser();
            case Defination::DATA_TYPE_USERS_INFO :
                return new DMS\User();
            case Defination::DATA_TYPE_DEALERS_INFO :
                return new DMS\Dealer($this->serviceResolver->regionService()->load());
            case Defination::DATA_TYPE_REGION_STAFF_INFO :
                return new DMS\RegionStaff($this->serviceResolver->regionService()->load());
            case Defination::DATA_TYPE_LOYALTY_HISTORICAL:
                return new DMS\LoyaltyHistorical();
            case Defination::DATA_TYPE_RANKING :
                return new DMS\Ranking();
            case Defination::DATA_TYPE_TERRITORY_REPORT:
                return new DMS\TerritoryReport();
            default:
                break;
        }
    }

    /**
     * @param string $type
     * @param array $parameters
     */
    public function export(string $type, array $parameters) {
        return $this->getExportService($type, $parameters)->export();
    }

    /**
     * @param $type
     * @param $parameters
     * @return Admin|LoyaltyHistorical|Ranking|RegionStaff|TerritoryReport|User
     */
    private function getExportService($type, $parameters) {
        switch ($type) {
            case 'admin':
                return new Admin();
            case 'region_staff':
                return new RegionStaff();
            case 'user':
                return new User($this->serviceResolver, $parameters);
            case 'historical_export':
                return new LoyaltyHistorical();
            case 'territory_report':
                return new TerritoryReport($this->serviceResolver, $parameters);
            case 'ranking':
                return new Ranking($this->serviceResolver, $parameters);
            default:
                break;
        }
    }
}
