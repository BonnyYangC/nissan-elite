<?php

namespace App\Services\DataMappingServices;


class ServiceManager extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'satisfaction' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'satisfaction_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'f1_nps' => $row['points_ce_FFT3_'] !== '' ? intval($row['points_ce_FFT3_']) : 0,
            'f1_nps_result' => $row['score_ce_FFT3_'] !== '' ? floatval($row['score_ce_FFT3_']) : 0.0,

            'follow_up' => $row['points_ce_PFU3_'] !== '' ? intval($row['points_ce_PFU3_']) : 0,
            'follow_up_result' => $row['score_ce_PFU3_'] !== '' ? floatval($row['score_ce_PFU3_']) : 0.0,

            'hot' => $row['points_ce_HOTA_'] !== '' ? intval($row['points_ce_HOTA_']) : 0,
            'hot_result' => $row['score_ce_HOTA_'] !== '' ? intval($row['score_ce_HOTA_']) : 0,

            'order_target' => $row['points_CPRO_'] !== '' ? intval($row['points_CPRO_']) : 0,
            'order_target_result' => $row['pcent_CPRO_'] !== '' ? floatval($row['pcent_CPRO_']) : 0.0,

            'retention' => $row['points_Retent_'] !== '' ? intval($row['points_Retent_']) : 0,
            'retention_result' => $row['pcent_RETENT_'] !== '' ? floatval($row['pcent_RETENT_']) : 0.0,

            'brake_wiper' => $row['points_BWP_'] !== '' ? intval($row['points_BWP_']) : 0,
            'brake_wiper_result' => $row['sales_BWP'] !== '' ? intval($row['sales_BWP']) : 0,

            'loyalty' => $row['points_loyalty_'] !== '' ? intval($row['points_loyalty_']) : 0,
            'loyalty_result' => $row['sales_loyalty'] !== '' ? floatval($row['sales_loyalty']) : 0.0,
        ];
    }
}
