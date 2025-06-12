<?php

namespace App\Services\DataServices;

use App\Helper\{Defination, Role};
use App\Services\DataMappingServices as DMS;
use App\Services\DataServices\Factories\{ImporterFactory, ValidatorFactory};
use App\Repositories\{PositionRepository, RegionRepository};
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Collection;

class DataProcessService {

    private $regionRepo;
    private $positionRepo;
    private $validatorFactory;
    private $importerFactory;

    public function __construct(RegionRepository $regionRepository, PositionRepository $positionRepository, ValidatorFactory $validatorFactory, ImporterFactory $importerFactory) {
        $this->regionRepo = $regionRepository;
        $this->positionRepo = $positionRepository;
        $this->validatorFactory = $validatorFactory;
        $this->importerFactory = $importerFactory;
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

        $updateCount = [0,0,0];
        $failedCount = [0,0,0];
        $failedRows = [[],[],[]];
        $ignoredCount = [0,0,0];
        $ignoredRows = [[],[],[]];
        $headerFields = [];

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');
            $headerFields = $csvReader->fetchOne(0);
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);

            $mappingServices = $this->getImporationService($dataType);
            foreach($mappingServices as $serviceKey => $service) {
                $modelKey = $service->getKeyForModel();
                $validationKey = $service->getKeyForValidate();

                foreach ($records as $lineNumber => $record) {
                    if(!isset($record[$modelKey['primary']]) || !$service->isValidate($record, $validationKey)) {
                        $failedCount[$serviceKey]++;
                        $failedRows[$serviceKey][] = $record;
                        continue;
                    }
                    if ($service::isIgnored($record, $validationKey)) {
                        $ignoredCount[$serviceKey]++;
                        $ignoredRows[$serviceKey][] = $record;
                        continue;
                    }
                    if (isset($modelKey['mapping'])) {
                        $keys = array_keys($modelKey['mapping']);
                    } else {
                        $keys = [$modelKey['primary']];
                    }

                    foreach($keys as $key) {
                        $model = $service->getModel($modelKey, $record, $key);

                        if ($model) {
                            $data = $service->buildData($model, $record, $modelKey, $key);
                            foreach ($data as $fieldName => $value) {
                                $model->$fieldName = $value == '-' ? 0 : $value;
                            }
                            if ($model->save()) {
                                $updateCount[$serviceKey]++;
                            } else {
                                $failedCount[$serviceKey]++;
                                $failedRows[$serviceKey][] = $record;
                            }
                        }
                    }
                }


            }
            $resultValue['type'] = Defination::ACTION_TYPE_SYNC;
            $resultValue['header'] = $headerFields;
            $resultValue['update']['count'] = 'Synced: '.$updateCount[0];//.$updateCount[1].$updateCount[2];
            $resultValue['ignore']['count'] = 'Ignored: '.$ignoredCount[0];//.$ignoredCount[1].$ignoredCount[2];
            $resultValue['ignore']['data'] = $ignoredRows[0];
            $resultValue['wrong']['count'] = 'Failed: '.$failedCount[0];//.$failedCount[1].$failedCount[2];
            $resultValue['wrong']['data'] = $failedRows[0];
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
            $mappingService = $this->validatorFactory->make($dataType);
            $modelKey = $mappingService->getKeyForModel();
            $validationKey = $mappingService->getKeyForValidate();
            
            foreach ($records as $lineNumber => $record) {

                if(!isset($record[$modelKey['primary']]) || !$mappingService->isValidate($record, $validationKey)) {
                    $wrongCount++;
                    $wrongRows[] = $record;
                    continue;
                }
                if ($mappingService::isIgnored($record, $validationKey)) {
                    $ignoredCount++;
                    $ignoredRows[] = $record;
                    continue;
                }
                $row = [];
                $headers = [];
                $model = $mappingService->getModel($modelKey, $record);
                if($model){
                    if ($dataType == Defination::DATA_TYPE_LOYALTY_HISTORICAL) {
                        foreach (array_keys($modelKey['mapping']) as $key) {
                            $newData = $mappingService->buildData($model, $record, $modelKey, $key);
                            list($equal, $existingModel) = $mappingService->compareRow($model, $newData);
                            if ($existingModel) {
                                $row = array_merge($row, $mappingService->buildResultRow($existingModel, $newData, $equal));
                                $findCount++;
                                $findRows[] = $row;
                            } else {
                                $row = array_merge($row, $mappingService->buildResultRow($existingModel, $newData, $equal));
                                $newRowCount++;
                                $newRows[] = $row;
                            }
                        }
                        $headers = array_merge($headers, $mappingService->buildHeaderForResultData($existingModel));
                        $headerFields = $headers;
                    } else {
                        $newData = $mappingService->buildData($model, $record, $modelKey, $modelKey['primary']);
                        foreach ($newData as $fieldName => $value) {
                            $equal = $mappingService->compareValue($fieldName, $model, $value);
                            $row = array_merge($row, $mappingService->buildResultData($fieldName, $model, $value, $equal));
                            $headers = array_merge($headers, $mappingService->buildHeaderForResultData($fieldName));
                        }
                    $findCount++;
                    $findRows[] = $row;
                    }
                }else{
                    $newRowCount++;
                    $newRows[] = $record;
                }

            }
            $resultValue['type'] = Defination::ACTION_TYPE_VALIDATE;
            $resultValue['wrong']['count'] = 'Wrong : (' . $wrongCount . ') ';
            if ($wrongCount) $resultValue['wrong']['count'] .= $mappingService->getValidateMessage();
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
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }

        return $resultValue;
    }

    /**
     * @param $type
     * @return Collection
     */
    private function getImporationService($type) {
        $actionType = Defination::ACTION_TYPE_SYNC;
        $returnValue = collect([]);
        switch ($type) {
            case Defination::DATA_TYPE_USERS_INFO :
                $returnValue = collect([new DMS\ImportationImpl\User(),new DMS\ImportationImpl\UsersEligible(), new DMS\ImportationImpl\UserPositions()]);
                break;
            case Defination::DATA_TYPE_DEALERS_INFO :
                $returnValue = collect([new DMS\ImportationImpl\Dealer(), new DMS\ImportationImpl\DealerRegion($this->regionRepo->load())]);
                break;
            case Defination::DATA_TYPE_REGION_STAFF_INFO :
                $returnValue->add(new DMS\ImportationImpl\RegionStaff($this->regionRepo->load()));
                break;
            case Defination::DATA_TYPE_LOYALTY_HISTORICAL:
                $returnValue->add(new DMS\ImportationImpl\LoyaltyHistorical());
                break;
            case Defination::DATA_TYPE_RANKING :
                $returnValue = collect([new DMS\ImportationImpl\Ranking(), new DMS\ImportationImpl\UserPositions()]);
                break;
            case Defination::DATA_TYPE_TERRITORY_REPORT:
                $returnValue->add(new DMS\ImportationImpl\TerritoryReport());
                break;
            default:
                $returnValue->add($this->getMonthlyDataService($type, $actionType));
                break;
        }
        return $returnValue;
    }


    /**
     * @param $type
     * @param $actionType
     */
    private function getMonthlyDataService($type, $actionType) {
        $returnValue = null;
        switch ($type) {
            case Role::FLEET_SALES_EXECUTIVES:
                $returnValue = new DMS\MonthlyDataImpl\FleetSalesExecutives($actionType);
                break;
            case Role::SALES_MANAGER:
                $returnValue = new DMS\MonthlyDataImpl\SalesManager($actionType);
                break;
            case Role::RETAIL_SALES_CONSULTANTS:
                $returnValue = new DMS\MonthlyDataImpl\RetailSalesConsultants($actionType);
                break;
            case Role::STOCK_CONTROLLER:
                $returnValue = new DMS\MonthlyDataImpl\StockController($actionType);
                break;
            case Role::FI:
                $returnValue = new DMS\MonthlyDataImpl\FI($actionType);
                break;
            case Role::PARTS_MANAGER:
                $returnValue = new DMS\MonthlyDataImpl\PartsManager($actionType);
                break;
            case Role::PARTS_SALES_REP:
                $returnValue = new DMS\MonthlyDataImpl\PartsSalesRep($actionType);
                break;
            case Role::SERVICE_MANAGER:
                $returnValue = new DMS\MonthlyDataImpl\ServiceManager($actionType);
                break;
            case Role::SERVICE_ADVISERS:
                $returnValue = new DMS\MonthlyDataImpl\ServiceAdvisor($actionType);
                break;
            case Role::TECHNICIAN:
                $returnValue = new DMS\MonthlyDataImpl\Technician($actionType);
                break;
            default:
                break;
        }
        return $returnValue;
    }

}
