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
            'new_vehicle_performance_result' => $row['pcent_ACT_S_'] !== '' ? floatval($row['pcent_ACT_S_']) : 0.0,

            //'pmp' => $row['points_pmp'] !== '' ? intval($row['points_pmp']) : 0,
            //'pmp_result' => $row['sales_pmp'] !== '' ? floatval($row['sales_pmp']) : 0,

            'satisfaction' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'satisfaction_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'kept_informed' => $row['points_ce_KID3_'] !== '' ? intval($row['points_ce_KID3_']) : 0,
            'kept_informed_result' => $row['score_ce_KID3_'] !== '' ? floatval($row['score_ce_KID3_']) : 0.0,

            'follow_up' => $row['points_ce_FUS3_'] !== '' ? intval($row['points_ce_FUS3_']) : 0,
            'follow_up_result' => $row['score_ce_FUS3_'] !== '' ? floatval($row['score_ce_FUS3_']) : 0.0,
        ];
    }
}
