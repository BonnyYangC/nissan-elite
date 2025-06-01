<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class Technician extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [

        'f1' => 'points_ce_dlr_D1_AS',
        'f1_result' => 'score_ce_dlr_D1_AS',

        '5_star' => 'points_ce_dlr_5Star_AS',
        '5_star_result' => 'score_ce_dlr_5Star_AS',

    ];
}
