<?php

namespace App\Services\DataMappingServices;


class StockController extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'comp_ow' => $row['points_compOW_'] !== '' ? intval($row['points_compOW_']) : 0,
            'comp_ow_result' => $row['score_compOW_'] !== '' ? intval($row['score_compOW_']) : 0,

            'retail_forecast' => $row['points_forecast_'] !== '' ? intval($row['points_forecast_']) : 0,
            'retail_forecast_result' => $row['ach_forecast_'] !== '' ? $row['ach_forecast_'] : 'NO',

            'matched_ow' => $row['points_matchOW_'] !== '' ? intval($row['points_matchOW_']) : 0,
            'matched_ow_result' => $row['score_matchOW_'] !== '' ? intval($row['score_matchOW_']) : 0,

            'fsp' => $row['points_FUTURE_P'] !== '' ? intval($row['points_FUTURE_P']) : 0,
            'fsp_result' => $row['sales_FUTURE_P'] !== '' ? intval($row['sales_FUTURE_P']) : 0,

            'nfv' => $row['points_NIC_stock'] !== '' ? intval($row['points_NIC_stock']) : 0,
            'nfv_result' => $row['sales_NIC_stock'] !== '' ? intval($row['sales_NIC_stock']) : 0,

            'nic_sale' => $row['points_NIC'] !== '' ? intval($row['points_NIC']) : 0,
            'nic_sale_result' => $row['sales_NIC'] !== '' ? intval($row['sales_NIC']) : 0,

            'reg_ret' => $row['points_regvret_'] !== '' ? intval($row['points_regvret_']) : 0,
            'reg_ret_result' => ($row['pcent_REGvRET_'] !== '' ? number_format(floatval($row['pcent_REGvRET_'])*100) : '0') . '%',
        ];
    }
}
