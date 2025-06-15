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

    public function importation($dataFile, $dataType) {

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');
            $headerFields = $csvReader->fetchOne(0);
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);

            $formattedRows = array_map(function ($row) use ($headerFields) {
                return array_combine($headerFields, $row);}, 
                iterator_to_array($records));

            // $mappingServices = $this->getImporationService($dataType);

            $mappingService = $this->importerFactory->make($dataType);

            return $mappingService->import($headerFields, $formattedRows);

        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }

    }

    public function validation($dataFile, $dataType) {

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');

            $headerFields = $csvReader->fetchOne(0);
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);
            $mappingService = $this->validatorFactory->make($dataType);

            return $mappingService->validate($headerFields, $records);
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }
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
