<?php

namespace App\Services;

use App\Services\MetricsServices\RetailSalesConsultants;
use App\Services\MetricsServices\SalesManager;
use App\Helper\{Role, Utility};
use Illuminate\Support\Facades\Auth;

class MetricsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    public function getMetricsService() {
        $currentUser = Auth::user();
        switch ($currentUser->position->code) {
            //case Role::FLEET_SALES_EXECUTIVES:
            //    return new FleetSalesExecutives();
            case Role::SALES_MANAGER:
                return new SalesManager();
            case Role::RETAIL_SALES_CONSULTANTS:
                return new RetailSalesConsultants();
            /*case Role::STOCK_CONTROLLER:
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
                return new ServiceAdviser();*/

            default:
                break;
        }
    }


    /**
     * @param bool $isStacked
     * @return mixed|string
     */
    public function getMetricsData(bool $isStacked = false) {
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $service = $this->getMetricsService();
        return $isStacked ? $service->buildStackedMetricsData($metrics) : $service->buildMetricsData($metrics);
    }
}
