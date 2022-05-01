<?php

namespace App\Services\DataMappingServices;


class StockController extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'stock_cover' => $row['points_stock_'] !== '' ? intval($row['points_stock_']) : 0,
            'stock_cover_result' => $row['score_STOCK_'] !== '' ? intval($row['score_STOCK_']) : 0,

            'ow' => $row['points_compOW_'] !== '' ? intval($row['points_compOW_']) : 0,
            'ow_result' => $row['score_compOW_'] !== '' ? intval($row['score_compOW_']) : 0,

            'retail' => $row['points_forecast_'] !== '' ? intval($row['points_forecast_']) : 0,
            'retail_result' => $row['ach_forecast_'] !== '' ? $row['ach_forecast_'] : 'NO',

            'matched_ow' => $row['points_matchOW_'] !== '' ? intval($row['points_matchOW_']) : 0,
            'matched_ow_result' => $row['score_matchOW_'] !== '' ? intval($row['score_matchOW_']) : 0,

            'davo' => $row['points_davo_'] !== '' ? intval($row['points_davo_']) : 0,
            'davo_result' => $row['pcent_DAVO_'] !== '' ? floatval($row['pcent_DAVO_']) : 0.0,

            'reg_ret' => $row['points_regvret_'] !== '' ? intval($row['points_regvret_']) : 0,
            'reg_ret_result' => $row['pcent_REGvRET_'] !== '' ? floatval($row['pcent_REGvRET_']) : 0.0,
        ];
    }
}
