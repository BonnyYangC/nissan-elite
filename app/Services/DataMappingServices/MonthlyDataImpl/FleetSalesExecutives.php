<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class FleetSalesExecutives extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'sales_status',

        'new_vehicle_fleet' => 'points_ACT_F',
        'new_vehicle_fleet_result' => 'pcent_ACT_F',

        'volume' => 'points_ACT_FV',
        'volume_result' => 'pcent_ACT_FV',
    ];
}
