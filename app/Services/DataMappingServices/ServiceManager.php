<?php

namespace App\Services\DataMappingServices;


class ServiceManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'sos' => 'points_ce_SOS3_',
        'sos_result' => 'score_ce_SOS3',

        'sos_navara' => 'points_ce_SOS3_N',
        'sos_navara_result' => 'score_ce_SOS3_N',
        'sos_patrol' => 'points_ce_SOS3_P',
        'sos_patrol_result' => 'score_ce_SOS3_P',

        'fft' => 'points_ce_FFT3_',
        'fft_result' => 'score_ce_FFT3_',

        'pfu' => 'points_ce_pfu3',
        'pfu_result' => 'score_ce_pfu3',

        'cwp' => 'points_ce_cwp3',
        'cwp_result' => 'score_ce_cwp3',

        'hot' => 'points_ce_HOTA_',
        'hot_result' => 'score_ce_HOTA_',

        'cpro_target' => 'points_CPRO_',
        'cpro_target_result' => 'pcent_CPRO_',

        'gp_cpro' => 'points_GPVAL_',
        'gp_cpro_result' => 'score_GPVAL_',

        'retention' => 'points_Retent_',
        'retention_result' => 'pcent_RETENT_',

        'loyalty' => 'points_loyalty_',
        'loyalty_result' => 'sales_loyalty',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'sos' => $row['points_ce_SOS3_'] !== '' ? intval($row['points_ce_SOS3_']) : 0,
            'sos_result' => $row['score_ce_SOS3'] !== '' ? number_format(floatval($row['score_ce_SOS3']), 1) : '0.0',

            'sos_navara' => $row['points_ce_SOS3_N'] !== '' ? intval($row['points_ce_SOS3_N']) : 0,
            'sos_navara_result' => $row['score_ce_SOS3_N'] !== '' ? number_format(floatval($row['score_ce_SOS3_N']), 1) : '0.0',
            'sos_patrol' => $row['points_ce_SOS3_P'] !== '' ? intval($row['points_ce_SOS3_P']) : 0,
            'sos_patrol_result' => $row['score_ce_SOS3_P'] !== '' ? number_format(floatval($row['score_ce_SOS3_P']), 1) : '0.0',

            'fft' => $row['points_ce_FFT3_'] !== '' ? intval($row['points_ce_FFT3_']) : 0,
            'fft_result' => $row['score_ce_FFT3_'] !== '' ? number_format(floatval($row['score_ce_FFT3_']), 1) : '0.0',

            'pfu' => $row['points_ce_pfu3'] !== '' ? intval($row['points_ce_pfu3']) : 0,
            'pfu_result' => $row['score_ce_pfu3'] !== '' ? number_format(floatval($row['score_ce_pfu3']), 1) : '0.0',

            'cwp' => $row['points_ce_cwp3'] !== '' ? intval($row['points_ce_cwp3']) : 0,
            'cwp_result' => $row['score_ce_cwp3'] !== '' ? number_format(floatval($row['score_ce_cwp3']), 1) : '0.0',

            'hot' => $row['points_ce_HOTA_'] !== '' ? intval($row['points_ce_HOTA_']) : 0,
            'hot_result' => $row['score_ce_HOTA_'] !== '' ? intval($row['score_ce_HOTA_']) : 0,

            'cpro_target' => $row['points_CPRO_'] !== '' ? intval($row['points_CPRO_']) : 0,
            'cpro_target_result' => ($row['pcent_CPRO_'] !== '' ? number_format(floatval($row['pcent_CPRO_'])*100) : '0') . '%',

            'gp_cpro' => $row['points_GPVAL_'] !== '' ? intval($row['points_GPVAL_']) : 0,
            'gp_cpro_result' => $row['score_GPVAL_'] !== '' ? '$'.intval($row['score_GPVAL_']) : 0,

            'retention' => $row['points_Retent_'] !== '' ? intval($row['points_Retent_']) : 0,
            'retention_result' => ($row['pcent_RETENT_'] !== '' ? number_format(floatval($row['pcent_RETENT_'])*100) : '0') . '%',

            'loyalty' => $row['points_loyalty_'] !== '' ? intval($row['points_loyalty_']) : 0,
            'loyalty_result' => $row['sales_loyalty'] !== '' ? intval($row['sales_loyalty']) : 0,
        ];
    }
}
