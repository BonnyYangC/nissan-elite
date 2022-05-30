<?php

namespace App\Services\DataMappingServices;


class PartsSalesRep extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'grp' => 'points_GRP_',
        'grp_result' => 'pcent_GRP_',

        'trade_sale_pvfy' => 'points_PvFY21_Q_',
        'trade_sale_pvfy_result' => 'pcent_PvFY21_Q_',
        'trade_sale_pvlq' => 'points_PvLQ_Q_',
        'trade_sale_pvlq_result' => 'pcent_PvLQ_Q_',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'grp' => $row['points_GRP_'] !== '' ? intval($row['points_GRP_']) : 0,
            'grp_result' => ($row['pcent_GRP_'] !== '' ? number_format(floatval($row['pcent_GRP_'])*100) : '0') . '%',

            'trade_sale_pvfy' => $row['points_PvFY21_Q_'] !== '' ? intval($row['points_PvFY21_Q_']) : 0,
            'trade_sale_pvfy_result' => ($row['pcent_PvFY21_Q_'] !== '' ? number_format(floatval($row['pcent_PvFY21_Q_'])*100) : '0') . '%',
            'trade_sale_pvlq' => $row['points_PvLQ_Q_'] !== '' ? intval($row['points_PvLQ_Q_']) : 0,
            'trade_sale_pvlq_result' => ($row['pcent_PvLQ_Q_'] !== '' ? number_format(floatval($row['pcent_PvLQ_Q_'])*100) : '0') . '%',

        ];
    }
}
