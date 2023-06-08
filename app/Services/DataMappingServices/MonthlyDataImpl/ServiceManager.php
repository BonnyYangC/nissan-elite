<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class ServiceManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',

        'sos_navara' => 'points_ce_SOS3_N',
        'sos_navara_result' => 'score_ce_SOS3_N',
        'sos_patrol' => 'points_ce_SOS3_P',
        'sos_patrol_result' => 'score_ce_SOS3_P',

        'fft' => 'points_ce_FFT3',
        'fft_result' => 'score_ce_FFT3',

        'hot' => 'points_ce_HOTA',
        'hot_result' => 'score_ce_HOTA',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',

        'cpro_target' => 'points_CPRO',
        'cpro_target_result' => 'pcent_CPRO',

        'gp_cpro' => 'points_WSgrp',
        'gp_cpro_result' => 'sales_WSgrp',

        'retention' => 'points_Retent_5',
        'retention_result' => 'pcent_RETENT_5',

        'service_retention' => 'points_Retent_1',
        'service_retention_result' => 'pcent_RETENT_1',

        'pmp' => 'points_PMP%retails' ,
        'pmp_result' =>  'pcent_PMP%retails' ,

        'loyalty' => 'points_loyalty',
        'loyalty_result' => 'sales_loyalty',
    ];

 
}
