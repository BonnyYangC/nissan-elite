<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class ServiceAdviser extends MonthlyDataMapping {
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

        'wac' => 'points_ce_WAC3',
        'wac_result' => 'score_ce_WAC3',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',

        'cpro_target' => 'points_CPRO',
        'cpro_target_result' => 'pcent_CPRO',

        'gp_cpro' => 'points_WSgrp',
        'gp_cpro_result' => 'sales_WSgrp',

        'service_retention' =>'points_Retent_1',
        'service_retention_result' =>'pcent_RETENT_1',

        'pmp' => 'points_PMP%retails',
        'pmp_result' => 'pcent_PMP%retails',

        'loyalty' => 'points_loyalty',
        'loyalty_result' => 'sales_loyalty',
    ];

  
}
