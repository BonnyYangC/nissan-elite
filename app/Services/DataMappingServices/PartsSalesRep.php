<?php

namespace App\Services\DataMappingServices;


class PartsSalesRep extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'grp' => $row['points_GRP_'] !== '' ? intval($row['points_GRP_']) : 0,
            'grp_result' => $row['pcent_GRP_'] !== '' ? floatval($row['pcent_GRP_']) : 0.0,

            'trade_sale_pvfy' => $row['points_PvFY20_Q_'] !== '' ? intval($row['points_PvFY20_Q_']) : 0,
            'trade_sale_pvfy_result' => $row['pcent_PvFY20_Q_'] !== '' ? floatval($row['pcent_PvFY20_Q_']) : 0.0,
            'trade_sale_pvlq' => $row['points_PvLQ_Q_'] !== '' ? intval($row['points_PvLQ_Q_']) : 0,
            'trade_sale_pvlq_result' => $row['pcent_PvLQ_Q_'] !== '' ? floatval($row['pcent_PvLQ_Q_']) : 0.0,

        ];
    }
}
