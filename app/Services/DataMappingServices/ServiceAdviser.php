<?php

namespace App\Services\DataMappingServices;


class ServiceAdviser extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'satisfaction' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'satisfaction_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'follow_up' => $row['points_ce_FUS3_'] !== '' ? intval($row['points_ce_FUS3_']) : 0,
            'follow_up_result' => $row['score_ce_PFU3_'] !== '' ? floatval($row['score_ce_PFU3_']) : 0.0,

            'explanation' => $row['points_ce_EOC3_'] !== '' ? intval($row['points_ce_EOC3_']) : 0,
            'explanation_result' => $row['score_ce_EOC3_'] !== '' ? intval($row['score_ce_EOC3_']) : 0,

            'brake_wiper' => $row['points_BWP_'] !== '' ? intval($row['points_BWP_']) : 0,
            'brake_wiper_result' => $row['sales_BWP'] !== '' ? intval($row['sales_BWP']) : 0,

            'loyalty' => $row['points_loyalty_'] !== '' ? intval($row['points_loyalty_']) : 0,
            'loyalty_result' => $row['sales_loyalty'] !== '' ? floatval($row['sales_loyalty']) : 0.0,
        ];
    }
}
