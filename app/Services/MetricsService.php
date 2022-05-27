<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\User;
use App\Services\MetricsServices\RetailSalesConsultants;
use App\Services\MetricsServices\SalesManager;
use App\Helper\Role;
use Illuminate\Support\Facades\Auth;

class MetricsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    public function getMetricsService() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        switch ($currentUser->position_code) {
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
     * @return mixed|string
     */
    public function getMetricsData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $service = $this->getMetricsService();
        return $service->buildMetricsData($metrics);
    }

    /**
     * @return Metric|void
     */
    public function getTrainingData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $trainingData = $currentUser->results()->keyBy('period');//->only(['train_online', 'train_competency', 'train_mastery', 'train_bonus', 'train_pathway', 'period']);
        $service = $this->getMetricsService();
        return $service->buildTrainingData($trainingData);
    }

    /**
     * @return false|string
     */
    public function getStackedMetricsData() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $metrics = $currentUser->results()->pluck('metrics', 'period');
        $trainingData = $currentUser->results()->keyBy('period');
        $service = $this->getMetricsService();
        return $service->buildStackedMetricsData($metrics, $trainingData);
    }
}
