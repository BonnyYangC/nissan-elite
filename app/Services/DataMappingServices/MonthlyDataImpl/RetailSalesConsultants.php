<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class RetailSalesConsultants extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'sales_status',
        'new_vehicle_performance' => 'points_NVR',
        'new_vehicle_performance_result' => 'pcent_ACT_S',

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',
        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',

        'kept_informed' => 'points_ce_KID3',
        'kept_informed_result' => 'score_ce_KID3',

        'follow_up' => 'points_ce_FUS3',
        'follow_up_result' => 'score_ce_FUS3',

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
            'new_vehicle_performance' => $row[$this->metricsMappingArray['new_vehicle_performance']] !== '' ? intval($row[$this->metricsMappingArray['new_vehicle_performance']]) : 0,
            'new_vehicle_performance_result' => ($row[$this->metricsMappingArray['new_vehicle_performance_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['new_vehicle_performance_result']])*100) : '0') . '%',

            'nfv' => $row[$this->metricsMappingArray['nfv']] !== '' ? intval($row[$this->metricsMappingArray['nfv']]) : 0,
            'nfv_result' => ($row[$this->metricsMappingArray['nfv_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['nfv_result']])*100) : '0') . '%',

            'nic_sale' => $row[$this->metricsMappingArray['nic_sale']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale']]) : 0,
            'nic_sale_result' => $row[$this->metricsMappingArray['nic_sale_result']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_result']]) : 0,
            'nic_sale_nfsa' => $row[$this->metricsMappingArray['nic_sale_nfsa']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_nfsa']]) : 0,
            'nic_sale_nfsa_result' => $row[$this->metricsMappingArray['nic_sale_nfsa_result']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_nfsa_result']]) : 0,

            'pmp' => $row[$this->metricsMappingArray['pmp']] !== '' ? intval($row[$this->metricsMappingArray['pmp']]) : 0,
            'pmp_result' => $row[$this->metricsMappingArray['pmp_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['pmp_result']]), 1) : '0.0',

            'sos' => $row[$this->metricsMappingArray['sos']] !== '' ? intval($row[$this->metricsMappingArray['sos']]) : 0,
            'sos_result' => $row[$this->metricsMappingArray['sos_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sos_result']]), 1) : '0.0',

            'kept_informed' => $row[$this->metricsMappingArray['kept_informed']] !== '' ? intval($row[$this->metricsMappingArray['kept_informed']]) : 0,
            'kept_informed_result' => $row[$this->metricsMappingArray['kept_informed_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['kept_informed_result']]), 1) : '0.0',

            'follow_up' => $row[$this->metricsMappingArray['follow_up']] !== '' ? intval($row[$this->metricsMappingArray['follow_up']]) : 0,
            'follow_up_result' => $row[$this->metricsMappingArray['follow_up_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['follow_up_result']]), 1) : '0.0',

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
            
        ];
    }
}
