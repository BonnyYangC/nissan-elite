<?php

namespace App\Services\DataMappingServices;


class FleetSalesExecutives extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'new_vehicle' => $row['points_SALES_STATUS_'] !== '' ? intval($row['points_SALES_STATUS_']) : 0,
            'new_vehicle_result' => $row['sales_status_'] !== '' ? intval($row['sales_status_']) : 0,

            'new_vehicle_fleet' => $row['points_ACT_F_'] !== '' ? intval($row['points_ACT_F_']) : 0,
            'new_vehicle_fleet_result' => ($row['pcent_ACT_F_'] !== '' ? number_format(floatval($row['pcent_ACT_F_'])*100) : '0') . '%',

            'volume' => $row['points_ACT_FV_'] !== '' ? intval($row['points_ACT_FV_']) : 0,
            'volume_result' => ($row['pcent_ACT_FV_'] !== '' ? number_format(floatval($row['pcent_ACT_FV_'])*100) : '0') . '%',
        ];
    }
}
