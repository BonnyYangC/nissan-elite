<?php

namespace App\Services\DataMappingServices;

class SalesManager extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'matched_ow' => $row['points_matchOW_'] !== '' ? intval($row['points_matchOW_']) : 0,
            'matched_ow_result' => $row['score_matchOW_'] !== '' ? intval($row['score_matchOW_']) : 0,

            'new_vehicle' => $row['points_SALES_STATUS_'] !== '' ? intval($row['points_SALES_STATUS_']) : 0,
            'new_vehicle_result' => $row['pcent_ACT_S_'] !== '' ? floatval($row['pcent_ACT_S_']) : 0.0,

            'sos' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'sos_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'booked_check' => $row['points_ce_PBKD3_'] !== '' ? intval($row['points_ce_PBKD3_']) : 0,
            'booked_check_result' => $row['score_ce_PBKD3'] !== '' ? floatval($row['score_ce_PBKD3']) : 0.0,

            'follow_up' => $row['points_ce_PFU3_'] !== '' ? intval($row['points_ce_PFU3_']) : 0,
            'follow_up_result' => $row['score_ce_PFU3_'] !== '' ? floatval($row['score_ce_PFU3_']) : 0.0,

            'hot' => $row['points_ce_HOTA_'] !== '' ? intval($row['points_ce_HOTA_']) : 0,
            'hot_result' => $row['score_ce_HOTA_'] !== '' ? intval($row['score_ce_HOTA_']) : 0,

            'retail' => $row['points_forecast_'] !== '' ? intval($row['points_forecast_']) : 0,
            'retail_result' => $row['ach_forecast_'] !== '' ? $row['ach_forecast_'] : 'NO',

            //'pmp' => $row['points_pmp'] !== '' ? $row['points_pmp'] : 0,
            //'pmp_result' => $row['sales_pmp'] !== '' ? $row['sales_pmp'] : 0,

            'apnur_n' => $row['points_APNUR_N_'] !== '' ? intval($row['points_APNUR_N_']) : 0,
            'apnur_n_result' => $row['pcent_APNUR_N_'] !== '' ? floatval($row['pcent_APNUR_N_']) : 0.0,
            'apnur_x' => $row['points_APNUR_X_'] !== '' ? intval($row['points_APNUR_X_']) : 0,
            'apnur_x_result' => $row['pcent_APNUR_X_'] !== '' ? floatval($row['pcent_APNUR_X_']) : 0.0,
            'apnur_q' => $row['points_APNUR_Q_'] !== '' ? intval($row['points_APNUR_Q_']) : 0,
            'apnur_q_result' => $row['pcent_APNUR_Q_'] !== '' ? floatval($row['pcent_APNUR_Q_']) : 0.0,
        ];
    }
}
