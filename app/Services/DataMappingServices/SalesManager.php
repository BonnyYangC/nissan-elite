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
            'new_vehicle_result' => ($row['pcent_ACT_S_'] !== '' ? number_format(floatval($row['pcent_ACT_S_'])*100) : '0') . '%',

            'fsp' => $row['points_FUTURE_P'] !== '' ? intval($row['points_FUTURE_P']) : 0,
            'fsp_result' => $row['SALES_FUTURE_P'] !== '' ? intval($row['SALES_FUTURE_P']) : 0,

            'nfv' => $row['points_NFV%'] !== '' ? intval($row['points_NFV%']) : 0,
            'nfv_result' => ($row['pcent_NFV%'] !== '' ? number_format(floatval($row['pcent_NFV%'])*100) : '0') . '%',

            'nic_sale' => $row['points_NIC'] !== '' ? intval($row['points_NIC']) : 0,
            'nic_sale_result' => $row['sales_NIC'] !== '' ? intval($row['sales_NIC']) : 0,
            'nic_sale_nfsa' => $row['points_NIC_Fnfsa'] !== '' ? intval($row['points_NIC_Fnfsa']) : 0,
            'nic_sale_nfsa_result' => $row['sales_NIC_Fnfsa'] !== '' ? intval($row['sales_NIC_Fnfsa']) : 0,

            'retail_forecast' => $row['points_forecast_'] !== '' ? intval($row['points_forecast_']) : 0,
            'retail_forecast_result' => $row['ach_forecast_'] !== '' ? $row['ach_forecast_'] : 'NO',

            'sos' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'sos_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'booked_check' => $row['points_ce_PBKD3_'] !== '' ? intval($row['points_ce_PBKD3_']) : 0,
            'booked_check_result' => $row['score_ce_PBKD3'] !== '' ? floatval($row['score_ce_PBKD3']) : 0.0,

            'follow_up' => $row['points_ce_PFU3_'] !== '' ? intval($row['points_ce_PFU3_']) : 0,
            'follow_up_result' => $row['score_ce_PFU3_'] !== '' ? floatval($row['score_ce_PFU3_']) : 0.0,

            'hot' => $row['points_ce_HOTA_'] !== '' ? intval($row['points_ce_HOTA_']) : 0,
            'hot_result' => $row['score_ce_HOTA_'] !== '' ? intval($row['score_ce_HOTA_']) : 0,

            'pmp' => $row['points_PMP'] !== '' ? intval($row['points_PMP']) : 0,
            'pmp_result' => $row['sales_PMP'] !== '' ? intval($row['sales_PMP']) : 0,

            'apnur_n' => $row['points_APNUR_N_'] !== '' ? intval($row['points_APNUR_N_']) : 0,
            'apnur_n_result' => ($row['pcent_APNUR_N_'] !== '' ? number_format(floatval($row['pcent_APNUR_N_'])*100) : '0') . '%',
            'apnur_x' => $row['points_APNUR_X_'] !== '' ? intval($row['points_APNUR_X_']) : 0,
            'apnur_x_result' => ($row['pcent_APNUR_X_'] !== '' ? number_format(floatval($row['pcent_APNUR_X_'])*100) : '0') . '%',
            'apnur_p' => $row['points_APNUR_P'] !== '' ? intval($row['points_APNUR_P']) : 0,
            'apnur_p_result' => ($row['pcent_APNUR_P'] !== '' ? number_format(floatval($row['pcent_APNUR_P'])*100) : '0') . '%',
        ];
    }
}
