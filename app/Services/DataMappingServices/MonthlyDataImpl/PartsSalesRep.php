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
       
        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',
    ];

 
}
