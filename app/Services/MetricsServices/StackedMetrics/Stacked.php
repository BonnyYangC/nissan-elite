<?php

namespace App\Services\MetricsServices\StackedMetrics;

use App\Helper\Role;
use App\Services\MetricsServices as MS;

class Stacked {
    private $position;

    public function get($serviceResolver) {
        $isCombined = theme_config('feature_metrics_stacked_combination');
        $isD1Positioned = in_array($this->position, [Role::FLEET_SALES_EXECUTIVES, Role::SALES_MANAGER, Role::RETAIL_SALES_CONSULTANTS, Role::STOCK_CONTROLLER, Role::FI]);
        $isF1Positioned = in_array($this->position, [Role::PARTS_MANAGER, Role::PARTS_SALES_REP, Role::SERVICE_ADVISERS, Role::SERVICE_MANAGER, Role::MASTER_TECHNICIAN, Role::ADVANCED_TECHNICIAN]);
        if($isCombined) {
            return (new MS\StackedMetrics\Themed\Stacked($serviceResolver))->setCombinedMetrics(
                $isD1Positioned ? 'd1' : 'f1'
            );
        }
        return new MS\StackedMetrics\Individual\Stacked($serviceResolver);
        
    }

    public function byPosition($value) {
        $this->position = $value;
        return $this;
    }

}