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

        'd1' => 'points_ce_dlr_D1_S',
        'd1_result' => 'score_ce_dlr_D1_S',

        '5_star' => 'points_ce_dlr_5Star_S',
        '5_star_result' => 'score_ce_dlr_5Star_S',
    ];
}
