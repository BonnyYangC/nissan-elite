<?php

namespace App\Services\DataMappingServices;

class SalesManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'matched_ow' => 'points_matchOW_',
        'matched_ow_result' => 'score_matchOW_',

        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'pcent_ACT_S_',

        'fsp' => 'points_FUTURE_P',
        'fsp_result' => 'SALES_FUTURE_P',

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',
        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fina',

        'retail_forecast' => 'points_forecast_',
        'retail_forecast_result' => 'ach_forecast_',

        'sos' => 'points_ce_SOS3_',
        'sos_result' => 'score_ce_SOS3',

        'booked_check' => 'points_ce_PBKD3_',
        'booked_check_result' => 'score_ce_PBKD3',

        'follow_up' => 'points_ce_PFU3_',
        'follow_up_result' => 'score_ce_PFU3_',

        'hot' => 'points_ce_HOTA_',
        'hot_result' => 'score_ce_HOTA_',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'apnur_n' => 'points_APNUR_N_',
        'apnur_n_result' => 'pcent_APNUR_N_',
        'apnur_x' => 'points_APNUR_X_',
        'apnur_x_result' => 'pcent_APNUR_X_',
        'apnur_p' => 'points_APNUR_P',
        'apnur_p_result' => 'pcent_APNUR_P'
        ];

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
            'fsp_result' => $row['sales_FUTURE_P'] !== '' ? intval($row['sales_FUTURE_P']) : 0,

            'nfv' => $row['points_NFV%'] !== '' ? intval($row['points_NFV%']) : 0,
            'nfv_result' => ($row['pcent_NFV%'] !== '' ? number_format(floatval($row['pcent_NFV%'])*100) : '0') . '%',

            'nic_sale' => $row['points_NIC'] !== '' ? intval($row['points_NIC']) : 0,
            'nic_sale_result' => $row['sales_NIC'] !== '' ? intval($row['sales_NIC']) : 0,
            'nic_sale_nfsa' => $row['points_NIC_Fnfsa'] !== '' ? intval($row['points_NIC_Fnfsa']) : 0,
            'nic_sale_nfsa_result' => $row['sales_NIC_fina'] !== '' ? intval($row['sales_NIC_fina']) : 0,

            'retail_forecast' => $row['points_forecast_'] !== '' ? intval($row['points_forecast_']) : 0,
            'retail_forecast_result' => $row['ach_forecast_'] !== '' ? $row['ach_forecast_'] : 'NO',

            'sos' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'sos_result' => $row['score_ce_SOS3'] !== '' ? number_format(floatval($row['score_ce_SOS3']), 1) : '0.0',

            'booked_check' => $row['points_ce_PBKD3_'] !== '' ? intval($row['points_ce_PBKD3_']) : 0,
            'booked_check_result' => $row['score_ce_PBKD3'] !== '' ? number_format(floatval($row['score_ce_PBKD3']), 1) : '0.0',

            'follow_up' => $row['points_ce_PFU3_'] !== '' ? intval($row['points_ce_PFU3_']) : 0,
            'follow_up_result' => $row['score_ce_PFU3_'] !== '' ? number_format(floatval($row['score_ce_PFU3_']), 1) : '0.0',

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
