<?php

namespace App\Services\DataMappingServices;


class FI extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'nfsa' => $row['points_nfsa'] !== '' ? intval($row['points_nfsa']) : 0,
            'nfsa_result' => $row['sales_nfsa_'] !== '' ? intval($row['sales_nfsa_']) : 0,

            'retention' => $row['points_nfsa_LRB_'] !== '' ? intval($row['points_nfsa_LRB_']) : 0,
            'retention_result' => $row['sales_nfsa_LRB_'] !== '' ? intval($row['sales_nfsa_LRB_']) : 0,

            'insurance_mvi' => $row['points_nfsa_MVI_'] !== '' ? intval($row['points_nfsa_MVI_']) : 0,
            'insurance_mvi_result' => $row['sales_nfsa_MVI_'] !== '' ? intval($row['sales_nfsa_MVI_']) : 0,
            'insurance_pkg' => $row['points_nfsa_PKG_'] !== '' ? intval($row['points_nfsa_PKG_']) : 0,
            'insurance_pkg_result' => $row['sales_nfsa_PKG_'] !== '' ? intval($row['sales_nfsa_PKG_']) : 0,

            'emw' => $row['points_nfsa_EMW_'] !== '' ? intval($row['points_nfsa_EMW_']) : 0,
            'emw_result' => $row['sales_nfsa_EMW_'] !== '' ? intval($row['sales_nfsa_EMW_']) : 0,

            'penetration' => $row['points_nfsa_PEN_'] !== '' ? intval($row['points_nfsa_PEN_']) : 0,
            'penetration_result' => $row['pcent_nfsa_PEN_'] !== '' ? floatval($row['pcent_nfsa_PEN_']) : 0.0,

            //'pmp' => $row['points_regvret_'] !== '' ? intval($row['points_regvret_']) : 0,
            //'pmp_result' => $row['pcent_REGvRET_'] !== '' ? floatval($row['pcent_REGvRET_']) : 0.0,

            'satisfaction' => $row['points_ce_EFI3_'] !== '' ? intval($row['points_ce_EFI3_']) : 0,
            'satisfaction_result' => $row['score_ce_EFI3_'] !== '' ? floatval($row['score_ce_EFI3_']) : 0.0,
        ];
    }
}
