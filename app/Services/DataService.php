<?php

namespace App\Services;

use App\Helper\Defination;
use App\Helper\Role;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Incentive;
use App\Services\DataMappingServices\FI;
use App\Services\DataMappingServices\FleetSalesExecutives;
use App\Services\DataMappingServices\LoyaltyHistorical as LoyaltyHistoricalMapping;
use App\Services\DataMappingServices\PartsManager;
use App\Services\DataMappingServices\PartsSalesRep;
use App\Services\DataMappingServices\RegionStaff;
use App\Services\DataMappingServices\RetailSalesConsultants;
use App\Services\DataMappingServices\SalesManager;
use App\Services\DataMappingServices\ServiceAdviser;
use App\Services\DataMappingServices\ServiceManager;
use App\Services\DataMappingServices\StockController;
use App\Services\DataMappingServices\User as UserMapping;
use App\Services\DataMappingServices\Dealer as DealerMapping;
use App\Services\DataMappingServices\Ranking as RankingMapping;
use App\Services\DataMappingServices\TerritoryReport as TerritoryReportMapping;
use App\Services\ExportServices\Admin;
use App\Services\ExportServices\LoyaltyHistorical;
use App\Services\ExportServices\TerritoryReport;
use App\Services\ExportServices\User;
use App\Services\ExportServices\Ranking;
use Illuminate\Http\Request;
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
            //var_dump($dataType);
            $mappingService = $this->getMappingService($dataType);
            $modelKey = $mappingService->getKeyForModel();

            foreach ($records as $lineNumber => $record) {
                if (empty($record[$modelKey['primary']])) {
                    $failCount++;
                    continue;
                }
                if ($mappingService::isIgnored($dataType, $record[$modelKey['primary']])) {
                    $ignoredCount++;
                    continue;
                }
                if (isset($modelKey['mapping'])) {
                    $keys = array_keys($modelKey['mapping']);
                } else {
                    $keys = [$modelKey['primary']];
                }
                foreach($keys as $key) {
                    $model = $mappingService->getModel(Defination::ACTION_TYPE_SYNC, $dataType, $modelKey, $record, $key);

                    if ($model) {
                        $data = $mappingService->buildData($model, $dataType, $record, $modelKey, $key);
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
     * @param $type
     * @return DealerMapping|FI|FleetSalesExecutives|LoyaltyHistoricalMapping|PartsManager|PartsSalesRep|RankingMapping|RegionStaff|RetailSalesConsultants|SalesManager|ServiceAdviser|ServiceManager|StockController|TerritoryReportMapping|UserMapping
     */
    private function getMappingService($type) {
        switch ($type) {
            case Role::FLEET_SALES_EXECUTIVES:
                return new FleetSalesExecutives();
            case Role::SALES_MANAGER:
                return new SalesManager();
            case Role::RETAIL_SALES_CONSULTANTS:
                return new RetailSalesConsultants();
            case Role::STOCK_CONTROLLER:
                return new StockController();
            case Role::FI:
                return new FI();
            case Role::PARTS_MANAGER:
                return new PartsManager();
            case Role::PARTS_SALES_REP:
                return new PartsSalesRep();
            case Role::SERVICE_MANAGER:
                return new ServiceManager();
            case Role::SERVICE_ADVISERS:
                return new ServiceAdviser();
            case Defination::DATA_TYPE_USERS_INFO :
                return new UserMapping();
            case Defination::DATA_TYPE_DEALERS_INFO :
                return new DealerMapping();
            case Defination::DATA_TYPE_REGION_STAFF_INFO :
                return new RegionStaff($this->serviceResolver->regionService()->load());
            case Defination::DATA_TYPE_LOYALTY_HISTORICAL:
                return new LoyaltyHistoricalMapping();
            case Defination::DATA_TYPE_RANKING :
                return new RankingMapping();
            case Defination::DATA_TYPE_TERRITORY_REPORT:
                return new TerritoryReportMapping();
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
     * @return Admin|LoyaltyHistorical|Ranking|TerritoryReport|User
     */
    private function getExportService($type, $parameters) {
        switch ($type) {
            case 'admin':
                return new Admin();
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

    /**
     * @param array $regions
     * @param string $dept
     * @param null $dealerNameKeyword
     * @return mixed
     */
    public function loadTerritoryReport(array $regions, $dept = 'All', $dealerNameKeyword = null){
        return $this->serviceResolver->territoryReportService()->load($regions,$dept,$dealerNameKeyword);
    }

    /**
     * @return mixed
     */
    public function loadEvents() {
        return $this->serviceResolver->eventService()->getEvents();
    }

    /**
     * @param array $input
     */
    public function updateEvent(array $input) {
        $incentives = $this->loadIncentives();
        $input['incentive_name'] = $incentives->filter(function($f) use ($input) {
            return $f->id === intval($input['incentive_id']);
        })->first()->title;
        $this->serviceResolver->eventService()->update($input);
    }

    /**
     * @param Event $event
     * @throws \Exception
     */
    public function deleteEvent(Event $event) {
        $this->serviceResolver->eventService()->delete($event);
    }

    /**
     * @return mixed
     */
    public function loadIncentives() {
        return $this->serviceResolver->incentivesService()->load();
    }

    /**
     * @return array
     */
    public function loadIncentivesByPeriod() {
        return [
            'current' => $this->serviceResolver->incentivesService()->current(),
            'past' => $this->serviceResolver->incentivesService()->past(),
            'just_finished' => $this->serviceResolver->incentivesService()->justFinished()
        ];
    }

    /**
     * @param Request $request
     */
    public function updateIncentive(Request $request) {
        $input = $request->input();
        if ($request->hasFile('image')) {
            $imagefileName = $request->file('image')->getClientOriginalName();
            $imageFile = $request->file('image')->storeAS('image', $imagefileName, 'public');
            rename(storage_path('app/public/'.$imageFile), public_path('images/incentives/images/'.$imagefileName));
            $input['image'] = $imagefileName;
        }
        if ($request->hasFile('pdf')) {
            $pdffileName = $request->file('pdf')->getClientOriginalName();
            $pdfFile = $request->file('pdf')->storeAS('image', $pdffileName, 'public');
            rename(storage_path('app/public/'.$pdfFile), public_path('images/incentives/images/pdf/'.$pdffileName));
            $input['pdf'] = $pdffileName;
        }
        $this->serviceResolver->incentivesService()->update($input);
    }

    /**
     * @param Incentive $incentive
     * @throws \Exception
     */
    public function deleteIncentive(Incentive $incentive) {
        $this->serviceResolver->incentivesService()->delete($incentive);
    }


    /**
     * @return mixed
     */
    public function loadFaqs() {
        return $this->serviceResolver->faqService()->load();
    }

    /**
     * @param Request $request
     */
    public function updateFaq(Request $request) {
        $this->serviceResolver->faqService()->update($request->input());
    }

    /**
     * @param Faq $faq
     */
    public function deleteFaq(Faq $faq) {
        $this->serviceResolver->faqService()->delete($faq);
    }
}
