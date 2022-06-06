<?php

namespace App\Services\DataMappingServices;


class ServiceAdviser extends MonthlyDataMapping {
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

        'cwp' => 'points_ce_cwp3',
        'cwp_result' => 'score_ce_cwp3',

        'eoc' => 'points_ce_EOC3_',
        'eoc_result' => 'score_ce_EOC3_',

        'cpro_target' => 'points_CPRO_',
        'cpro_target_result' => 'pcent_CPRO_',

        'gp_cpro' => 'points_GPVAL_',
        'gp_cpro_result' => 'score_GPVAL_',

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
            'sos_result' => $row['score_ce_SOS3'] !== '' ? number_format(floatval($row['score_ce_SOS3']), 1) : '00.0',

            'sos_navara' => $row['points_ce_SOS3_N'] !== '' ? intval($row['points_ce_SOS3_N']) : 0,
            'sos_navara_result' => $row['score_ce_SOS3_N'] !== '' ? number_format(floatval($row['score_ce_SOS3_N']), 1) : '00.0',
            'sos_patrol' => $row['points_ce_SOS3_P'] !== '' ? intval($row['points_ce_SOS3_P']) : 0,
            'sos_patrol_result' => $row['score_ce_SOS3_P'] !== '' ? number_format(floatval($row['score_ce_SOS3_P']), 1) : '00.0',

            'fft' => $row['points_ce_FFT3_'] !== '' ? intval($row['points_ce_FFT3_']) : 0,
            'fft_result' => $row['score_ce_FFT3_'] !== '' ? number_format(floatval($row['score_ce_FFT3_']), 1) : '00.0',

            'cwp' => $row['points_ce_cwp3'] !== '' ? intval($row['points_ce_cwp3']) : 0,
            'cwp_result' => $row['score_ce_cwp3'] !== '' ? number_format(floatval($row['score_ce_cwp3']), 1) : '00.0',

            'eoc' => $row['points_ce_EOC3_'] !== '' ? intval($row['points_ce_EOC3_']) : 0,
            'eoc_result' => $row['score_ce_EOC3_'] !== '' ? number_format(floatval($row['score_ce_EOC3_']), 1) : '00.0',

            'cpro_target' => $row['points_CPRO_'] !== '' ? intval($row['points_CPRO_']) : 0,
            'cpro_target_result' => ($row['pcent_CPRO_'] !== '' ? number_format(floatval($row['pcent_CPRO_'])*100) : '0') . '%',

            'gp_cpro' => $row['points_GPVAL_'] !== '' ? intval($row['points_GPVAL_']) : 0,
            'gp_cpro_result' => $row['score_GPVAL_'] !== '' ? intval($row['score_GPVAL_']) : 0,

            'loyalty' => $row['points_loyalty_'] !== '' ? intval($row['points_loyalty_']) : 0,
            'loyalty_result' => $row['sales_loyalty'] !== '' ? number_format(floatval($row['sales_loyalty']), 1) : '00.0',
        ];
    }
}
