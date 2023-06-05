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

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'comp_ow' => $row[$this->metricsMappingArray['comp_ow']] !== '' ? intval($row[$this->metricsMappingArray['comp_ow']]) : 0,
            'comp_ow_result' => $row[$this->metricsMappingArray['comp_ow_result']] !== '' ? intval($row[$this->metricsMappingArray['comp_ow_result']]) : 0,

            'retail_forecast' => $row[$this->metricsMappingArray['retail_forecast']] !== '' ? intval($row[$this->metricsMappingArray['retail_forecast']]) : 0,
            'retail_forecast_result' => $row[$this->metricsMappingArray['retail_forecast_result']] !== '' ? $row[$this->metricsMappingArray['retail_forecast_result']] : 'NO',

            'matched_ow' => $row[$this->metricsMappingArray['matched_ow']] !== '' ? intval($row[$this->metricsMappingArray['matched_ow']]) : 0,
            'matched_ow_result' => $row[$this->metricsMappingArray['matched_ow_result']] !== '' ? intval($row[$this->metricsMappingArray['matched_ow_result']]) : 0,

            'fsp' => $row[$this->metricsMappingArray['fsp']] !== '' ? intval($row[$this->metricsMappingArray['fsp']]) : 0,
            'fsp_result' => $row[$this->metricsMappingArray['fsp_result']] !== '' ? intval($row[$this->metricsMappingArray['fsp_result']]) : 0,

            'reg_ret' => $row[$this->metricsMappingArray['reg_ret']] !== '' ? intval($row[$this->metricsMappingArray['reg_ret']]) : 0,
            'reg_ret_result' => ($row[$this->metricsMappingArray['reg_ret_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['reg_ret_result']])*100) : '0') . '%',

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
 
        ];
    }
}
