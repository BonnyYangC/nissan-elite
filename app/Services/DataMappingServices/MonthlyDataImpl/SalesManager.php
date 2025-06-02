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

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',

        'apnur_n' => 'points_APNUR_N',
        'apnur_n_result' => 'pcent_APNUR_N',
        'apnur_x' => 'points_APNUR_X',
        'apnur_x_result' => 'pcent_APNUR_X',
        'apnur_p' => 'points_APNUR_P',
        'apnur_p_result' => 'pcent_APNUR_P',

        'd1' => 'points_ce_dlr_D1_S',
        'd1_result' => 'score_ce_dlr_D1_S',

        '5_star' => 'points_ce_dlr_5Star_S',
        '5_star_result' => 'score_ce_dlr_5Star_S',

        'ce' => 'points_ce_dlr_survey_S',
        'ce_result' => 'pcent_ce_dlr_survey_S',
        ];
}
