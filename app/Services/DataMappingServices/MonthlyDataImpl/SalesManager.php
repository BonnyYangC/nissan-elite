<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class SalesManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'matched_ow' => 'points_matchOW',
        'matched_ow_result' => 'score_matchOW',

        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'pcent_ACT_S',

        'fsp' => 'points_FUTURE_P',
        'fsp_result' => 'sales_FUTURE_P',

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',
        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'apnur_n' => 'points_APNUR_N',
        'apnur_n_result' => 'pcent_APNUR_N',
        'apnur_x' => 'points_APNUR_X',
        'apnur_x_result' => 'pcent_APNUR_X',
        'apnur_p' => 'points_APNUR_P',
        'apnur_p_result' => 'pcent_APNUR_P',

        'retail_forecast' => 'points_forecast',
        'retail_forecast_result' => 'ach_forecast_',
        ];
}
