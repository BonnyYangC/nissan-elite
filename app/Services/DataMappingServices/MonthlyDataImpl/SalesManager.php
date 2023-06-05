<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class SalesManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'matched_ow' => 'points_matchOW',
        'matched_ow_result' => 'score_matchOW',

        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'pcent_ACT_S',

        'fsp' => 'points_FUTURE_P',
        'fsp_result' => 'sales_FUTURE_P',

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',
        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'apnur_n' => 'points_APNUR_N',
        'apnur_n_result' => 'pcent_APNUR_N',
        'apnur_x' => 'points_APNUR_X',
        'apnur_x_result' => 'pcent_APNUR_X',
        'apnur_p' => 'points_APNUR_P',
        'apnur_p_result' => 'pcent_APNUR_P',

        'retail_forecast' => 'points_forecast',
        'retail_forecast_result' => 'ach_forecast_',

        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',

        'booked_check' => 'points_ce_PBKD3',
        'booked_check_result' => 'score_ce_PBKD3',

        'follow_up' => 'points_ce_PFU3',
        'follow_up_result' => 'score_ce_PFU3',

        'hot' => 'points_ce_HOTA',
        'hot_result' => 'score_ce_HOTA',
        
        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',


        ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'matched_ow' => $row[$this->metricsMappingArray['matched_ow']] !== '' ? intval($row[$this->metricsMappingArray['matched_ow']]) : 0,
            'matched_ow_result' => $row[$this->metricsMappingArray['matched_ow_result']] !== '' ? intval($row[$this->metricsMappingArray['matched_ow_result']]) : 0,

            'new_vehicle' => $row[$this->metricsMappingArray['new_vehicle']] !== '' ? intval($row[$this->metricsMappingArray['new_vehicle']]) : 0,
            'new_vehicle_result' => ($row[$this->metricsMappingArray['new_vehicle_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['new_vehicle_result']])*100) : '0') . '%',

            'fsp' => $row[$this->metricsMappingArray['fsp']] !== '' ? intval($row[$this->metricsMappingArray['fsp']]) : 0,
            'fsp_result' => $row[$this->metricsMappingArray['fsp_result']] !== '' ? intval($row[$this->metricsMappingArray['fsp_result']]) : 0,

            'nfv' => $row[$this->metricsMappingArray['nfv']] !== '' ? intval($row[$this->metricsMappingArray['nfv']]) : 0,
            'nfv_result' => ($row[$this->metricsMappingArray['nfv_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['nfv_result']])*100) : '0') . '%',

            'nic_sale' => $row[$this->metricsMappingArray['nic_sale']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale']]) : 0,
            'nic_sale_result' => $row[$this->metricsMappingArray['nic_sale_result']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_result']]) : 0,
            'nic_sale_nfsa' => $row[$this->metricsMappingArray['nic_sale_nfsa']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_nfsa']]) : 0,
            'nic_sale_nfsa_result' => $row[$this->metricsMappingArray['nic_sale_nfsa_result']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_nfsa_result']]) : 0,
            
            'pmp' => $row[$this->metricsMappingArray['pmp']] !== '' ? intval($row[$this->metricsMappingArray['pmp']]) : 0,
            'pmp_result' => $row[$this->metricsMappingArray['pmp_result']] !== '' ? intval($row[$this->metricsMappingArray['pmp_result']]) : 0,
            
            'apnur_n' => $row[$this->metricsMappingArray['apnur_n']] !== '' ? intval($row[$this->metricsMappingArray['apnur_n']]) : 0,
            'apnur_n_result' => ($row[$this->metricsMappingArray['apnur_n_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['apnur_n_result']])*100) : '0') . '%',
            'apnur_x' => $row[$this->metricsMappingArray['apnur_x']] !== '' ? intval($row[$this->metricsMappingArray['apnur_x']]) : 0,
            'apnur_x_result' => ($row[$this->metricsMappingArray['apnur_x_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['apnur_x_result']])*100) : '0') . '%',
            'apnur_p' => $row[$this->metricsMappingArray['apnur_p']] !== '' ? intval($row[$this->metricsMappingArray['apnur_p']]) : 0,
            'apnur_p_result' => ($row[$this->metricsMappingArray['apnur_p_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['apnur_p_result']])*100) : '0') . '%',
      
            'retail_forecast' => $row[$this->metricsMappingArray['retail_forecast']] !== '' ? intval($row[$this->metricsMappingArray['retail_forecast']]) : 0,
            'retail_forecast_result' => $row[$this->metricsMappingArray['retail_forecast_result']] !== '' ? $row[$this->metricsMappingArray['retail_forecast_result']] : 'NO',

            'sos' => $row[$this->metricsMappingArray['sos']] !== '' ? intval($row[$this->metricsMappingArray['sos']]) : 0,
            'sos_result' => $row[$this->metricsMappingArray['sos_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sos_result']]), 1) : '0.0',

            'booked_check' => $row[$this->metricsMappingArray['booked_check']] !== '' ? intval($row[$this->metricsMappingArray['booked_check']]) : 0,
            'booked_check_result' => $row[$this->metricsMappingArray['booked_check_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['booked_check_result']]), 1) : '0.0',

            'follow_up' => $row[$this->metricsMappingArray['follow_up']] !== '' ? intval($row[$this->metricsMappingArray['follow_up']]) : 0,
            'follow_up_result' => $row[$this->metricsMappingArray['follow_up_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['follow_up_result']]), 1) : '0.0',

            'hot' => $row[$this->metricsMappingArray['hot']] !== '' ? intval($row[$this->metricsMappingArray['hot']]) : 0,
            'hot_result' => $row[$this->metricsMappingArray['hot_result']] !== '' ? intval($row[$this->metricsMappingArray['hot_result']]) : 0,

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
            
            ];
    }
}
