<?php

namespace App\Services\DataMappingServices;


class RetailSalesConsultants extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'new_vehicle' => $row['points_SALES_STATUS_'] !== '' ? intval($row['points_SALES_STATUS_']) : 0,
            'new_vehicle_result' => $row['sales_status_'] !== '' ? intval($row['sales_status_']) : 0,
            'new_vehicle_performance' => $row['points_NVR_'] !== '' ? intval($row['points_NVR_']) : 0,
            'new_vehicle_performance_result' => ($row['pcent_ACT_S_'] !== '' ? number_format(floatval($row['pcent_ACT_S_']), 2) : '0') . '%',

            'nfv' => $row['points_NFV%'] !== '' ? intval($row['points_NFV%']) : 0,
            'nfv_result' => ($row['pcent_NFV%'] !== '' ? $row['pcent_NFV%'] : '0') . '%',

            'nic_sale' => $row['points_NIC'] !== '' ? intval($row['points_NIC']) : 0,
            'nic_sale_result' => $row['sales_NIC'] !== '' ? intval($row['sales_NIC']) : 0,
            'nic_sale_nfsa' => $row['points_NIC_Fnfsa'] !== '' ? intval($row['points_NIC_Fnfsa']) : 0,
            'nic_sale_nfsa_result' => $row['sales_NIC_Fnfsa'] !== '' ? intval($row['sales_NIC_Fnfsa']) : 0,

            'pmp' => $row['points_PMP'] !== '' ? intval($row['points_PMP']) : 0,
            'pmp_result' => $row['sales_PMP'] !== '' ? floatval($row['sales_PMP']) : 0,

            'satisfaction' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'satisfaction_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'kept_informed' => $row['points_ce_KID3_'] !== '' ? intval($row['points_ce_KID3_']) : 0,
            'kept_informed_result' => $row['score_ce_KID3_'] !== '' ? floatval($row['score_ce_KID3_']) : 0.0,

            'follow_up' => $row['points_ce_FUS3_'] !== '' ? intval($row['points_ce_FUS3_']) : 0,
            'follow_up_result' => $row['score_ce_FUS3_'] !== '' ? floatval($row['score_ce_FUS3_']) : 0.0,
        ];
    }
}
