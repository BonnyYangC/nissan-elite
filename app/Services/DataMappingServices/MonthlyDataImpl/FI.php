<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class FI extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'nfsa' => 'points_nfsa',
        'nfsa_result' => 'sales_nfsa_',

        'rff' => 'points_nfsa_facility',
        'rff_result' => 'sales_nfsa_ffacility',

        'lrb' => 'points_nfsa_LRB',
        'lrb_result' => 'sales_nfsa_LRB_',

        'insurance_mvi' => 'points_nfsa_MVI',
        'insurance_mvi_result' => 'sales_nfsa_MVI_',
        'insurance_pkg' => 'points_nfsa_PKG',
        'insurance_pkg_result' => 'sales_nfsa_PKG_',

        'penetration' => 'points_nfsa_PEN',
        'penetration_result' => 'pcent_nfsa_PEN',

        'nfv' => 'points_nfsa_NFV',
        'nfv_result' => 'sales_nfsa_NFV',
        'nfv_nfsa' => 'points_NFV%',
        'nfv_nfsa_result' => 'pcent_NFV%',

        'nfv_retails' => 'points_NFV%_Retail',
        'nfv_retails_result' => 'pcent_NFV%Retail',

        'nic_sale_nfsa' => 'points_nfsa_NICF',
        'nic_sale_nfsa_result' => 'sales_nfsa_NICF_',

        'd1' => 'points_ce_dlr_D1_S',
        'd1_result' => 'score_ce_dlr_D1_S',

        '5_star' => 'points_ce_dlr_5Star_S',
        '5_star_result' => 'score_ce_dlr_5Star_S',
    ];
}
