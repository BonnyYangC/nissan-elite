<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class ServiceAdviser extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',

        'sos_navara' => 'points_ce_SOS3_N',
        'sos_navara_result' => 'score_ce_SOS3_N',
        'sos_patrol' => 'points_ce_SOS3_P',
        'sos_patrol_result' => 'score_ce_SOS3_P',

        'fft' => 'points_ce_FFT3',
        'fft_result' => 'score_ce_FFT3',

        'eoc' => 'points_ce_WAC3',
        'eoc_result' => 'score_ce_WAC3',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',

        'cpro_target' => 'points_CPRO',
        'cpro_target_result' => 'pcent_CPRO',

        'gp_cpro' => 'points_WSgrp',
        'gp_cpro_result' => 'sales_WSgrp',

        'service_retention' =>'points_Retent_1',
        'service_retention_result' =>'pcent_RETENT_1',

        'pmp' => 'points_PMP%retails',
        'pmp_result' => 'pcent_PMP%retails',

        'loyalty' => 'points_loyalty',
        'loyalty_result' => 'sales_loyalty',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'sos' => $row[$this->metricsMappingArray['sos']] !== '' ? intval($row[$this->metricsMappingArray['sos']]) : 0,
            'sos_result' => $row[$this->metricsMappingArray['sos_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sos_result']]), 1) : '0.0',

            'sos_navara' => $row[$this->metricsMappingArray['sos_navara']] !== '' ? intval($row[$this->metricsMappingArray['sos_navara']]) : 0,
            'sos_navara_result' => $row[$this->metricsMappingArray['sos_navara_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sos_navara_result']]), 1) : '0.0',
            'sos_patrol' => $row[$this->metricsMappingArray['sos_patrol']] !== '' ? intval($row[$this->metricsMappingArray['sos_patrol']]) : 0,
            'sos_patrol_result' => $row[$this->metricsMappingArray['sos_patrol_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sos_patrol_result']]), 1) : '0.0',

            'fft' => $row[$this->metricsMappingArray['fft']] !== '' ? intval($row[$this->metricsMappingArray['fft']]) : 0,
            'fft_result' => $row[$this->metricsMappingArray['fft_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['fft_result']]), 1) : '0.0',

            'eoc' => $row[$this->metricsMappingArray['eoc']] !== '' ? intval($row[$this->metricsMappingArray['eoc']]) : 0,
            'eoc_result' => $row[$this->metricsMappingArray['eoc_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['eoc_result']]), 1) : '0.0',

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
 
            'cpro_target' => $row[$this->metricsMappingArray['cpro_target']] !== '' ? intval($row[$this->metricsMappingArray['cpro_target']]) : 0,
            'cpro_target_result' => ($row[$this->metricsMappingArray['cpro_target_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['cpro_target_result']])*100) : '0') . '%',

            'gp_cpro' => $row[$this->metricsMappingArray['gp_cpro']] !== '' ? intval($row[$this->metricsMappingArray['gp_cpro']]) : 0,
            'gp_cpro_result' => $row[$this->metricsMappingArray['gp_cpro_result']] !== '' ? intval($row[$this->metricsMappingArray['gp_cpro_result']]) : 0,

            'service_retention' =>$row[$this->metricsMappingArray['service_retention']] !== '' ? intval($row[$this->metricsMappingArray['service_retention']]) : 0,
            'service_retention_result' =>($row[$this->metricsMappingArray['service_retention_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['service_retention_result']])*100) : '0') . '%',
    
            'pmp' => $row[$this->metricsMappingArray['pmp']] !== '' ? intval($row[$this->metricsMappingArray['pmp']]) : 0,
            'pmp_result' => ($row[$this->metricsMappingArray['pmp_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['pmp_result']])*100) : '0') . '%',
    
            'loyalty' => $row[$this->metricsMappingArray['loyalty']] !== '' ? intval($row[$this->metricsMappingArray['loyalty']]) : 0,
            'loyalty_result' => $row[$this->metricsMappingArray['loyalty_result']] !== '' ? intval($row[$this->metricsMappingArray['loyalty_result']]) : 0,
        ];
    }
}
