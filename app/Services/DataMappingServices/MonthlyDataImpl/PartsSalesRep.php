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

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'grp' => $row[$this->metricsMappingArray['grp']] !== '' ? intval($row[$this->metricsMappingArray['grp']]) : 0,
            'grp_result' => ($row[$this->metricsMappingArray['grp_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['grp_result']])*100) : '0') . '%',

            'trade_sale_pvfy' => $row[$this->metricsMappingArray['trade_sale_pvfy']] !== '' ? intval($row[$this->metricsMappingArray['trade_sale_pvfy']]) : 0,
            'trade_sale_pvfy_result' => ($row[$this->metricsMappingArray['trade_sale_pvfy_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['trade_sale_pvfy_result']])*100) : '0') . '%',
            'trade_sale_pvlq' => $row[$this->metricsMappingArray['trade_sale_pvlq']] !== '' ? intval($row[$this->metricsMappingArray['trade_sale_pvlq']]) : 0,
            'trade_sale_pvlq_result' => ($row[$this->metricsMappingArray['trade_sale_pvlq_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['trade_sale_pvlq_result']])*100) : '0') . '%',

            'sdr' => $row[$this->metricsMappingArray['sdr']] !== '' ? intval($row[$this->metricsMappingArray['sdr']]) : 0,
            'sdr_result' => $row[$this->metricsMappingArray['sdr_result']] !== '' ? number_format(floatval($row[$this->metricsMappingArray['sdr_result']]),2) : 0,
 
        ];
    }
}
