<?php

namespace App\Services;

use App\Helper\Defination;
use App\Services\DataMappingServices as DMS;
use App\Helper\Role;
use App\Services\ExportServices\{Admin, LoyaltyHistorical, RegionStaff, TerritoryReport, User, Ranking};
use App\Repositories\{PositionRepository, RegionRepository};
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Collection;

class DataService extends BaseService {

    private $regionRepo;
    private $positionRepo;

    public function __construct(ServiceResolver $serviceResolver, RegionRepository $regionRepository, PositionRepository $positionRepository) {
        parent::__construct($serviceResolver);
        $this->regionRepo = $regionRepository;
        $this->positionRepo = $positionRepository;
    }

    /**
     * @return mixed
     */
    public function getPositions() {
        return $this->positionRepo->loadMembers();
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

            $mappingServices = $this->getImporationService($dataType);
            foreach($mappingServices as $service) {
                $modelKey = $service->getKeyForModel();
            
                foreach ($records as $lineNumber => $record) {

                    if(!isset($record[$modelKey['primary']]) || !$service->validate(trim($record[$modelKey['primary']]))) {
                        $failCount++;
                        continue;
                    }
                    if ($service::isIgnored($record[$modelKey['primary']])) {
                        $ignoredCount++;
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
                                $updateCount++;
                            } else {
                                $failCount++;
                            }
                        }
                    }
                }
            }
            $resultValue['type'] = Defination::ACTION_TYPE_SYNC;
            $resultValue['update'] = $updateCount / $mappingServices->count();
            $resultValue['ignore'] = $ignoredCount / $mappingServices->count();
            $resultValue['wrong'] = $failCount / $mappingServices->count();
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
            $mappingService = $this->getValidationService($dataType);
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
                    $model = $mappingService->getModel($modelKey, $record, $key);
                    if($model){
                        $data = $mappingService->buildData($model, $record, $modelKey, $key);
                        foreach ($data as $fieldName => $value) {
                            $equal = $mappingService->compareValue($fieldName, $model, $value);
                            $row = array_merge($row, $mappingService->buildResultData($fieldName, $model, $value, $equal));
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
     * @return Collection
     */
    private function getImporationService($type) {
        $actionType = Defination::ACTION_TYPE_SYNC;
        $returnValue = collect([]);
        switch ($type) {
            case Defination::DATA_TYPE_USERS_INFO :
                $returnValue = collect([new DMS\ImportationImpl\User(),new DMS\ImportationImpl\UsersEligible()]);
                break;
            case Defination::DATA_TYPE_DEALERS_INFO :
                $returnValue->add(new DMS\ImportationImpl\Dealer($this->regionRepo->load()));
                break;
            case Defination::DATA_TYPE_REGION_STAFF_INFO :
                $returnValue->add(new DMS\ImportationImpl\RegionStaff($this->regionRepo->load()));
                break;
            case Defination::DATA_TYPE_LOYALTY_HISTORICAL:
                $returnValue->add(new DMS\ImportationImpl\LoyaltyHistorical());
                break;
            case Defination::DATA_TYPE_RANKING :
                $returnValue->add(new DMS\ImportationImpl\Ranking());
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
     */
    private function getValidationService($type) {
        $actionType = Defination::ACTION_TYPE_VALIDATE;
        $returnValue = null;
        switch ($type) {
            case Defination::DATA_TYPE_USERS_INFO :
                $returnValue = new DMS\ValidationImpl\User();
                break;
            case Defination::DATA_TYPE_DEALERS_INFO :
                $returnValue = new DMS\ValidationImpl\Dealer($this->regionRepo->load());
                break;
            case Defination::DATA_TYPE_REGION_STAFF_INFO :
                $returnValue = new DMS\ValidationImpl\RegionStaff($this->regionRepo->load());
                break;
            case Defination::DATA_TYPE_LOYALTY_HISTORICAL:
                $returnValue = new DMS\ValidationImpl\LoyaltyHistorical();
                break;
            case Defination::DATA_TYPE_RANKING :
                $returnValue = new DMS\ValidationImpl\Ranking();
                break;
            case Defination::DATA_TYPE_TERRITORY_REPORT:
                $returnValue = new DMS\ValidationImpl\TerritoryReport();
                break;
            default:
                $returnValue = $this->getMonthlyDataService($type, $actionType);
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
                $returnValue = new DMS\MonthlyDataImpl\ServiceAdviser($actionType);
                break;
            default:
                break;
        }
        return $returnValue;
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
        $ReturnValue = null;
        switch ($type) {
            case 'admin':
                $ReturnValue = new Admin();
                break;
            case 'region_staff':
                $ReturnValue = new RegionStaff();
                break;
            case 'user':
                $ReturnValue = new User($this->serviceResolver, $parameters);
                break;
            case 'historical_export':
                $ReturnValue = new LoyaltyHistorical();
                break;
            case 'territory_report':
                $ReturnValue = new TerritoryReport($this->serviceResolver, $parameters);
                break;
            case 'ranking':
                $ReturnValue = new Ranking($this->serviceResolver, $parameters);
                break;
            default:
                break;
        }
        return $ReturnValue;
    }
}
