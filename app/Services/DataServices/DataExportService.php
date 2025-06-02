<?php

namespace App\Services\DataServices;

use App\Services\{BaseService, ServiceResolver};
use App\Services\ExportServices\{Admin, LoyaltyHistorical, RegionStaff, TerritoryReport, User, Ranking};

class DataExportService extends BaseService {

    public function __construct(ServiceResolver $serviceResolver) {
        parent::__construct($serviceResolver);
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
