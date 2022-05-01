<?php

namespace App\Services;

use App\Helper\Color;
use App\Helper\Utility;
use App\Services\StatusServices\GageStatus;
use Illuminate\Support\Facades\Auth;

class MetricsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

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

    /**
     * @param $metrics
     * @return mixed
     */
    public function buildMetricsData($metrics) {
        $currentUser = Auth::user();
        $metricsDefinations = $currentUser->position->metrics->sortBy('order');

        $chartData = [];
        foreach(Utility::MONTHS_SHORT as $month) {
            $dateString = date('Y-m-01', strtotime($month));
            if(isset($metrics[$dateString])) {
                foreach ($metricsDefinations as $m) {
                    if (!isset($chartData[$m->identifier])) $chartData[$m->identifier] = [['Month', 'Points']];
                    if (isset($metrics[$dateString][$m->identifier])) {
                        $chartData[$m->identifier][] = [$month, $metrics[$dateString][$m->identifier]];
                    } else {
                        $chartData[$m->identifier][] = [$month, 0];
                    }
                }
            } else {
                foreach ($metricsDefinations as $m) {
                    if (!isset($chartData[$m->identifier])) $chartData[$m->identifier] = [['Month', 'Points']];
                    $chartData[$m->identifier][] = [$month, 0];
                }
            }
        }
        $metricsDefinations->each(function($m) use ($chartData) {
            $m->chart_data = json_encode($chartData[$m->identifier]);
            $m->table_data = ['RESULT' => ['100','100','100','100','100','100','100','100','100','100','100','100']];
            $m->chart_name = 'chart_'.$m->identifier;
            // $m->guides = json_decode($m->guides);
        });
        return $metricsDefinations;
    }
}
