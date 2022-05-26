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
     * @param string $label
     * @param string $backgroundColor
     * @param array $data
     * @return array
     */
    private function _buildMetricsChartData(string $label, string $backgroundColor, array $data) {
        return [
            'label'=>$label,
            'backgroundColor' => $backgroundColor,
            'data'=>$data
        ];
    }

    /**
     * @param $result
     * @return array
     */
    private function getBaseMetrics($result) {
        return [
            // $this->_buildMetricsChartData('Dealer Excellence', Colors::GAINS_BORO, $this->excellence),
            // $this->_buildMetricsChartData('Registration', Colors::DARK_GREEN, $this->registration),
        ];
    }

    /**
     * @param $metrics
     * @return string
     */
    public function buildStackedMetricsData($metrics): string {
        $currentUser = Auth::user();
        $metricsDefinations = $currentUser->position->metrics->sortBy('order');

        $result = [];
        foreach ($metrics as $key => $val) {
            $result[] = $metricsDefinations->reduce(function($r, $m) use ($key, $val) {
                $r[] = data_get($val, $m->identifier, 0);
                return $r;
            }, [date("M", strtotime($key))]);
	}
	if (!$result) {
            foreach (Utility::MONTHS_SHORT as $month) {
                $result[] = $metricsDefinations->reduce(function($r, $m) {
                    $r[] = 0;
                    return $r;
                }, [$month]);
            }
        }
        $metricsLegend = $metricsDefinations->reduce(function($r, $m) {
            $r[] = $m->label;
            return $r;
        }, ['genre']);

        return json_encode(array_merge([$metricsLegend], $result, [
            // $this->_buildMetricsChartData('Matched OW', Color::BRONZE, $matchedOW),
            // $this->_buildMetricsChartData('New Vehicle Sales', Color::SADDLE_BROWN, $newVehicleSales),
            // $this->_buildMetricsChartData('Overall Sat', Color::LOW_RED, $salesOverallSatisfaction),
            // $this->_buildMetricsChartData('% Booked', Colors::LIGHT_PERU, $booked),
            // $this->_buildMetricsChartData('% Follow Up', Colors::SILVER, $percentageFollowUp),
            // $this->_buildMetricsChartData('Hot Alert', Colors::DARK_KHAKI, $hotAlert),
            // $this->_buildMetricsChartData('Forecast', Colors::DARK_GREY, $forecast),
            // $this->_buildMetricsChartData('PMP', Colors::BasicLifetime, $pmp),
            // $this->_buildMetricsChartData('APNUR', Colors::LIGHT_GREEN, $apnur),
            // $this->_buildMetricsChartData('Training', Colors::LEMON_CHIFFON, $trainingData),
            // $this->_buildMetricsChartData('Incentive', Colors::GOLD, $incentivesForDashboard)
        ], $this->getBaseMetrics($metrics)));

    }
}
