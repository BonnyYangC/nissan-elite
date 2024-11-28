<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class PartsSalesRep extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'grp' => 'points_GRP',
        'grp_result' => 'pcent_GRP',

        'trade_sale_pvfy' => 'points_PG_YvY_Q_',
        'trade_sale_pvfy_result' => 'pcent_PG_YvY_Q',
        'trade_sale_pvlq' => 'points_PG_QvLQ_Q_',
        'trade_sale_pvlq_result' => 'pcent_PG_QvLQ_Q',
        
        'f1' => 'points_ce_dlr_D1_AS',
        'f1_result' => 'score_ce_dlr_D1_AS',

        '5_star' => 'points_ce_dlr_5Star_AS',
        '5_star_result' => 'score_ce_dlr_5Star_AS',
    ];

 
}
