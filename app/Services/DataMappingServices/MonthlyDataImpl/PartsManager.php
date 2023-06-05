<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class PartsManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'grp' => 'points_GRP',
        'grp_result' => 'pcent_GRP',

        'acc' => 'points_ACC',
        'acc_result' => 'pcent_ACC',

        'apnur_n' => 'points_APNUR_N',
        'apnur_n_result' => 'pcent_APNUR_N',
        'apnur_x' => 'points_APNUR_X',
        'apnur_x_result' => 'pcent_APNUR_X',
        'apnur_am' => 'points_APNUR_AM_parts',
        'apnur_am_result' => 'pcent_APNUR_AM_parts',


        'gp_cpro' => 'points_WSgrp',
        'gp_cpro_result' => 'sales_WSgrp',

        'bw_cpro' => 'points_BAW',
        'bw_cpro_result' => 'sales_BAW',

        'rim' => 'points_RIM',
        'rim_result' => 'pcent_RIM',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'grp' => $row[$this->metricsMappingArray['grp']] !== '' ? intval($row[$this->metricsMappingArray['grp']]) : 0,
            'grp_result' => ($row[$this->metricsMappingArray['grp_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['grp_result']])*100) : '0') . '%',

            'acc' => $row[$this->metricsMappingArray['acc']] !== '' ? intval($row[$this->metricsMappingArray['acc']]) : 0,
            'acc_result' => ($row[$this->metricsMappingArray['acc_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['acc_result']])*100) : '0') . '%',

            'apnur_n' => $row[$this->metricsMappingArray['apnur_n']] !== '' ? intval($row[$this->metricsMappingArray['apnur_n']]) : 0,
            'apnur_n_result' => ($row[$this->metricsMappingArray['apnur_n_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['apnur_n_result']])*100) : '0') . '%',
            'apnur_x' => $row[$this->metricsMappingArray['apnur_x']] !== '' ? intval($row[$this->metricsMappingArray['apnur_x']]) : 0,
            'apnur_x_result' => ($row[$this->metricsMappingArray['apnur_x_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['apnur_x_result']])*100) : '0') . '%',
            'apnur_am' => $row[$this->metricsMappingArray['apnur_am']] !== '' ? intval($row[$this->metricsMappingArray['apnur_am']]) : 0,
            'apnur_am_result' => ($row[$this->metricsMappingArray['apnur_am_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['apnur_am_result']])*100) : '0') . '%',
            
            'gp_cpro' => $row[$this->metricsMappingArray['gp_cpro']] !== '' ? intval($row[$this->metricsMappingArray['gp_cpro']]) : 0,
            'gp_cpro_result' => $row[$this->metricsMappingArray['gp_cpro_result']] !== '' ? intval($row[$this->metricsMappingArray['gp_cpro_result']]) : 0,

            'bw_cpro' =>  $row[$this->metricsMappingArray['bw_cpro']] !== '' ? intval($row[$this->metricsMappingArray['bw_cpro']]) : 0,
            'bw_cpro_result' =>  $row[$this->metricsMappingArray['bw_cpro_result']] !== '' ? intval($row[$this->metricsMappingArray['bw_cpro_result']]) : 0,

            'rim' => $row[$this->metricsMappingArray['rim']] !== '' ? intval($row[$this->metricsMappingArray['rim']]) : 0,
            'rim_result' => ($row[$this->metricsMappingArray['rim_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['rim_result']])*100) : '0') . '%',
        
            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
 
        ];
    }
}
