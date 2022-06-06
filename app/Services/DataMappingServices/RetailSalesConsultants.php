<?php

namespace App\Services\DataMappingServices;


class RetailSalesConsultants extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'sales_status_',
        'new_vehicle_performance' => 'points_NVR_',
        'new_vehicle_performance_result' => 'pcent_ACT_S_',

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',
        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'sos' => 'points_ce_SOS3_',
        'sos_result' => 'score_ce_SOS3',

        'kept_informed' => 'points_ce_KID3_',
        'kept_informed_result' => 'score_ce_KID3_',

        'follow_up' => 'points_ce_FUS3_',
        'follow_up_result' => 'score_ce_FUS3_',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'new_vehicle' => $row['points_SALES_STATUS_'] !== '' ? intval($row['points_SALES_STATUS_']) : 0,
            'new_vehicle_result' => $row['sales_status_'] !== '' ? intval($row['sales_status_']) : 0,
            'new_vehicle_performance' => $row['points_NVR_'] !== '' ? intval($row['points_NVR_']) : 0,
            'new_vehicle_performance_result' => ($row['pcent_ACT_S_'] !== '' ? number_format(floatval($row['pcent_ACT_S_'])*100) : '0') . '%',

            'nfv' => $row['points_NFV%'] !== '' ? intval($row['points_NFV%']) : 0,
            'nfv_result' => ($row['pcent_NFV%'] !== '' ? number_format(floatval($row['pcent_NFV%'])*100) : '0') . '%',

            'nic_sale' => $row['points_NIC'] !== '' ? intval($row['points_NIC']) : 0,
            'nic_sale_result' => $row['sales_NIC'] !== '' ? intval($row['sales_NIC']) : 0,
            'nic_sale_nfsa' => $row['points_NIC_Fnfsa'] !== '' ? intval($row['points_NIC_Fnfsa']) : 0,
            'nic_sale_nfsa_result' => $row['sales_NIC_fnfsa'] !== '' ? intval($row['sales_NIC_fnfsa']) : 0,

            'pmp' => $row['points_PMP'] !== '' ? intval($row['points_PMP']) : 0,
            'pmp_result' => $row['sales_PMP'] !== '' ? number_format(floatval($row['sales_PMP']), 1) : '0.0',

            'sos' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'sos_result' => $row['score_ce_SOS3'] !== '' ? number_format(floatval($row['score_ce_SOS3']), 1) : '0.0',

            'kept_informed' => $row['points_ce_KID3_'] !== '' ? intval($row['points_ce_KID3_']) : 0,
            'kept_informed_result' => $row['score_ce_KID3_'] !== '' ? number_format(floatval($row['score_ce_KID3_']), 1) : '0.0',

            'follow_up' => $row['points_ce_FUS3_'] !== '' ? intval($row['points_ce_FUS3_']) : 0,
            'follow_up_result' => $row['score_ce_FUS3_'] !== '' ? number_format(floatval($row['score_ce_FUS3_']), 1) : '0.0',
        ];
    }
}
