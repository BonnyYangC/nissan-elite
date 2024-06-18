<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class ServiceManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
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
