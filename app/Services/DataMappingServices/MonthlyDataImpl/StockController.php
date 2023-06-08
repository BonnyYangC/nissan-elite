<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class StockController extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'comp_ow' => 'points_compOW',
        'comp_ow_result' => 'score_compOW',

        'retail_forecast' => 'points_forecast',
        'retail_forecast_result' => 'ach_forecast_',

        'matched_ow' => 'points_matchOW',
        'matched_ow_result' => 'score_matchOW',

        'fsp' => 'points_FUTURE_P',
        'fsp_result' => 'sales_FUTURE_P',

        'reg_ret' => 'points_regvret',
        'reg_ret_result' => 'pcent_REGvRET',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',
    
    ];

 
}
