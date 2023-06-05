<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class FI extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'nfsa' => 'points_nfsa',
        'nfsa_result' => 'sales_nfsa_',

        'lrb' => 'points_nfsa_LRB',
        'lrb_result' => 'sales_nfsa_LRB_',

        'insurance_mvi' => 'points_nfsa_MVI',
        'insurance_mvi_result' => 'sales_nfsa_MVI_',
        'insurance_pkg' => 'points_nfsa_PKG',
        'insurance_pkg_result' => 'sales_nfsa_PKG_',

        'penetration' => 'points_nfsa_PEN',
        'penetration_result' => 'pcent_nfsa_PEN',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'nfv' => 'points_NFV',
        'nfv_result' => 'sales_NFV',
        'nfv_nfsa' => 'points_NFV%',
        'nfv_nfsa_result' => 'pcent_NFV%',

        'nfv_retails' => 'points_NFV%_Retail',
        'nfv_retails_result' => 'pcent_NFV%Retail',


        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'satisfaction' => 'points_ce_EFI3',
        'satisfaction_result' => 'score_ce_EFI3',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'nfsa' => $row[$this->metricsMappingArray['nfsa']] !== '' ? intval($row[$this->metricsMappingArray['nfsa']]) : 0,
            'nfsa_result' => $row[$this->metricsMappingArray['nfsa_result']] !== '' ? intval($row[$this->metricsMappingArray['nfsa_result']]) : 0,

            'lrb' => $row[$this->metricsMappingArray['lrb']] !== '' ? intval($row[$this->metricsMappingArray['lrb']]) : 0,
            'lrb_result' => $row[$this->metricsMappingArray['lrb_result']] !== '' ? intval($row[$this->metricsMappingArray['lrb_result']]) : 0,

            'insurance_mvi' => $row[$this->metricsMappingArray['insurance_mvi']] !== '' ? intval($row[$this->metricsMappingArray['insurance_mvi']]) : 0,
            'insurance_mvi_result' => $row[$this->metricsMappingArray['insurance_mvi_result']] !== '' ? intval($row[$this->metricsMappingArray['insurance_mvi_result']]) : 0,
            'insurance_pkg' => $row[$this->metricsMappingArray['insurance_pkg']] !== '' ? intval($row[$this->metricsMappingArray['insurance_pkg']]) : 0,
            'insurance_pkg_result' => $row[$this->metricsMappingArray['insurance_pkg_result']] !== '' ? intval($row[$this->metricsMappingArray['insurance_pkg_result']]) : 0,

            'penetration' => $row[$this->metricsMappingArray['penetration']] !== '' ? intval($row[$this->metricsMappingArray['penetration']]) : 0,
            'penetration_result' => ($row[$this->metricsMappingArray['penetration_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['penetration_result']])*100) : '0') . '%',

            'pmp' => $row[$this->metricsMappingArray['pmp']] !== '' ? intval($row[$this->metricsMappingArray['pmp']]) : 0,
            'pmp_result' => $row[$this->metricsMappingArray['pmp_result']] !== '' ? intval($row[$this->metricsMappingArray['pmp_result']]) : 0,

            'nfv' => $row[$this->metricsMappingArray['nfv']] !== '' ? intval($row[$this->metricsMappingArray['nfv']]) : 0,
            'nfv_result' => $row[$this->metricsMappingArray['nfv_result']] !== '' ? intval($row[$this->metricsMappingArray['nfv_result']]) : 0,
            'nfv_nfsa' => $row[$this->metricsMappingArray['nfv_nfsa']] !== '' ? intval($row[$this->metricsMappingArray['nfv_nfsa']]) : 0,
            'nfv_nfsa_result' => ($row[$this->metricsMappingArray['nfv_nfsa_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['nfv_nfsa_result']])*100) : '0') . '%',

            'nfv_retails' => $row[$this->metricsMappingArray['nfv_retails']] !== '' ? intval($row[$this->metricsMappingArray['nfv_retails']]) : 0,
            'nfv_retails_result' => ($row[$this->metricsMappingArray['nfv_retails_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['nfv_retails_result']])*100) : '0') . '%',

            'nic_sale_nfsa' => $row[$this->metricsMappingArray['nic_sale_nfsa']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_nfsa']]) : 0,
            'nic_sale_nfsa_result' => $row[$this->metricsMappingArray['nic_sale_nfsa_result']] !== '' ? intval($row[$this->metricsMappingArray['nic_sale_nfsa_result']]) : 0,

            'satisfaction' => $row[$this->metricsMappingArray['satisfaction']] !== '' ? intval($row[$this->metricsMappingArray['satisfaction']]) : 0,
            'satisfaction_result' => $row[$this->metricsMappingArray['satisfaction_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['satisfaction_result']]), 1) : '0.0',

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
 
        ];
    }
}
