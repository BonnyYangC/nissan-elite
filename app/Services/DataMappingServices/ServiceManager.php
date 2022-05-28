<?php

namespace App\Services\DataMappingServices;


class ServiceManager extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'sos' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'sos_result' => $row['score_ce_SOS3'] !== '' ? floatval($row['score_ce_SOS3']) : 0.0,

            'sos_navara' => $row['points_ce_SOS3_N'] !== '' ? intval($row['points_ce_SOS3_N']) : 0,
            'sos_navara_result' => $row['score_ce_SOS3_N'] !== '' ? floatval($row['score_ce_SOS3_N']) : 0.0,
            'sos_patrol' => $row['points_ce_SOS3_P'] !== '' ? intval($row['points_ce_SOS3_P']) : 0,
            'sos_patrol_result' => $row['score_ce_SOS3_P'] !== '' ? floatval($row['score_ce_SOS3_P']) : 0.0,

            'fft' => $row['points_ce_FFT3_'] !== '' ? intval($row['points_ce_FFT3_']) : 0,
            'fft_result' => $row['score_ce_FFT3_'] !== '' ? floatval($row['score_ce_FFT3_']) : 0.0,

            'cwp' => $row['points_ce_cwp3'] !== '' ? intval($row['points_ce_cwp3']) : 0,
            'cwp_result' => $row['score_ce_cwp3'] !== '' ? intval($row['score_ce_cwp3']) : 0,

            'hot' => $row['points_ce_HOTA_'] !== '' ? intval($row['points_ce_HOTA_']) : 0,
            'hot_result' => $row['score_ce_HOTA_'] !== '' ? intval($row['score_ce_HOTA_']) : 0,

            'cpro_target' => $row['points_CPRO_'] !== '' ? intval($row['points_CPRO_']) : 0,
            'cpro_target_result' => ($row['pcent_CPRO_'] !== '' ? number_format(floatval($row['pcent_CPRO_'])*100) : '0') . '%',

            'gp_cpro' => $row['points_GPVAL_'] !== '' ? intval($row['points_GPVAL_']) : 0,
            'gp_cpro_result' => $row['score_GPVAL_'] !== '' ? intval($row['score_GPVAL_']) : 0,

            'retention' => $row['points_Retent_'] !== '' ? intval($row['points_Retent_']) : 0,
            'retention_result' => ($row['pcent_RETENT_'] !== '' ? number_format(floatval($row['pcent_RETENT_'])*100) : '0') . '%',

            'loyalty' => $row['points_loyalty_'] !== '' ? intval($row['points_loyalty_']) : 0,
            'loyalty_result' => $row['sales_loyalty'] !== '' ? intval($row['sales_loyalty']) : 0,
        ];
    }
}
