<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class PartsManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'grp' => 'points_GRP',
        'grp_result' => 'pcent_GRP',

        'acc' => 'points_ACC',
        'acc_result' => 'pcent_ACC',

        'apnur_n' => 'points_APNUR_N',
        'apnur_n_result' => 'pcent_APNUR_N',
        'apnur_x' => 'points_APNUR_X',
        'apnur_x_result' => 'pcent_APNUR_X',
        'apnur_am' => 'points_APNUR_AM_parts',
        'apnur_am_result' => 'pcent_APNUR_AM_parts',


        'gp_cpro' => 'points_WSgrp',
        'gp_cpro_result' => 'sales_WSgrp',

        'bw_cpro' => 'points_BAW',
        'bw_cpro_result' => 'sales_BAW',

        'rim' => 'points_RIM',
        'rim_result' => 'pcent_RIM_Item',
        'rim_qualifier_result' => 'pcent_RIM_order',
        
        'f1' => 'points_ce_dlr_D1_AS',
        'f1_result' => 'score_ce_dlr_D1_AS',

        '5_star' => 'points_ce_dlr_5Star_AS',
        '5_star_result' => 'score_ce_dlr_5Star_AS',
    ];
}
