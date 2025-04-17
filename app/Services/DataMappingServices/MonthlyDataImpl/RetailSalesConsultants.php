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

        'd1' => 'points_ce_ind_D1_S',
        'd1_result' => 'score_ce_ind_D1_S',

        '5_star' => 'points_ce_ind_5star_S',
        '5_star_result' => 'score_ce_ind_5star_S',

        'ce' => 'points_ce_dlr_survey_S',
        'ce_result' => 'pcent_ce_dlr_survey_S',
    ];
}
