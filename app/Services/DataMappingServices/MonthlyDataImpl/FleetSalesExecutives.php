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

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',

    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'new_vehicle' => $row[$this->metricsMappingArray['new_vehicle']] !== '' ? intval($row[$this->metricsMappingArray['new_vehicle']]) : 0,
            'new_vehicle_result' => $row[$this->metricsMappingArray['new_vehicle_result']] !== '' ? intval($row[$this->metricsMappingArray['new_vehicle_result']]) : 0,

            'new_vehicle_fleet' => $row[$this->metricsMappingArray['new_vehicle_fleet']] !== '' ? intval($row[$this->metricsMappingArray['new_vehicle_fleet']]) : 0,
            'new_vehicle_fleet_result' => ($row[$this->metricsMappingArray['new_vehicle_fleet_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['new_vehicle_fleet_result']])*100) : '0') . '%',

            'volume' => $row[$this->metricsMappingArray['volume']] !== '' ? intval($row[$this->metricsMappingArray['volume']]) : 0,
            'volume_result' => ($row[$this->metricsMappingArray['volume_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['volume_result']])*100) : '0') . '%',

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
 
        ];
    }
}
