<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class Technician extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'f1' => 'points_ce_FFT3',
        'f1_result' => 'score_ce_FFT3',

        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',
    ];

  
}
