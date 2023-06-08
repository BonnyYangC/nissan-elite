<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class FI extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'nfsa' => 'points_nfsa',
        'nfsa_result' => 'sales_nfsa_',

        'lrb' => 'points_nfsa_LRB',
        'lrb_result' => 'sales_nfsa_LRB_',

        'insurance_mvi' => 'points_nfsa_MVI',
        'insurance_mvi_result' => 'sales_nfsa_MVI_',
        'insurance_pkg' => 'points_nfsa_PKG',
        'insurance_pkg_result' => 'sales_nfsa_PKG_',

        'penetration' => 'points_nfsa_PEN',
        'penetration_result' => 'pcent_nfsa_PEN',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'nfv' => 'points_NFV',
        'nfv_result' => 'sales_NFV',
        'nfv_nfsa' => 'points_NFV%',
        'nfv_nfsa_result' => 'pcent_NFV%',

        'nfv_retails' => 'points_NFV%_Retail',
        'nfv_retails_result' => 'pcent_NFV%Retail',


        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'satisfaction' => 'points_ce_EFI3',
        'satisfaction_result' => 'score_ce_EFI3',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',
    ];
}
