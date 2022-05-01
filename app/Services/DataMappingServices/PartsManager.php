<?php

namespace App\Services\DataMappingServices;


class PartsManager extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'grp' => $row['points_GRP_'] !== '' ? intval($row['points_GRP_']) : 0,
            'grp_result' => $row['pcent_GRP_'] !== '' ? floatval($row['pcent_GRP_']) : 0.0,

            'gas' => $row['points_ACC_'] !== '' ? intval($row['points_ACC_']) : 0,
            'gas_result' => $row['pcent_ACC_'] !== '' ? floatval($row['pcent_ACC_']) : 0.0,

            'apnur_n' => $row['points_APNUR_N_'] !== '' ? intval($row['points_APNUR_N_']) : 0,
            'apnur_n_result' => $row['pcent_APNUR_N_'] !== '' ? floatval($row['pcent_APNUR_N_']) : 0.0,
            'apnur_x' => $row['points_APNUR_X_'] !== '' ? intval($row['points_APNUR_X_']) : 0,
            'apnur_x_result' => $row['pcent_APNUR_X_'] !== '' ? floatval($row['pcent_APNUR_X_']) : 0.0,
            'apnur_q' => $row['points_APNUR_Q_'] !== '' ? intval($row['points_APNUR_Q_']) : 0,
            'apnur_q_result' => $row['pcent_APNUR_Q_'] !== '' ? floatval($row['pcent_APNUR_Q_']) : 0.0,

            'brake_wiper' => $row['points_BWP_'] !== '' ? intval($row['points_BWP_']) : 0,
            'brake_wiper_result' => $row['sales_BWP'] !== '' ? intval($row['sales_BWP']) : 0,
        ];
    }
}
