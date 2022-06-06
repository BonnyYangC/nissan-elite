<?php

namespace App\Services\DataMappingServices;


class PartsManager extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'grp' => 'points_GRP_',
        'grp_result' => 'pcent_GRP_',

        'acc' => 'points_ACC_',
        'acc_result' => 'pcent_ACC_',

        'apnur_n' => 'points_APNUR_N_',
        'apnur_n_result' => 'pcent_APNUR_N_',
        'apnur_am' => 'points_APNUR_AM_parts',
        'apnur_am_result' => 'pcent_APNUR_AM_parts',
        'apnur_p' => 'points_APNUR_P',
        'apnur_p_result' => 'pcent_APNUR_P',

        'gp_cpro' => 'points_GPVAL_',
        'gp_cpro_result' => 'score_GPVAL_',

        'rim' => 'points_RIM',
        'rim_result' => 'pcent_RIM',
    ];

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'grp' => $row['points_GRP_'] !== '' ? intval($row['points_GRP_']) : 0,
            'grp_result' => ($row['pcent_GRP_'] !== '' ? number_format(floatval($row['pcent_GRP_'])*100) : '0') . '%',

            'acc' => $row['points_ACC_'] !== '' ? intval($row['points_ACC_']) : 0,
            'acc_result' => ($row['pcent_ACC_'] !== '' ? number_format(floatval($row['pcent_ACC_'])*100) : '0') . '%',

            'apnur_n' => $row['points_APNUR_N_'] !== '' ? intval($row['points_APNUR_N_']) : 0,
            'apnur_n_result' => ($row['pcent_APNUR_N_'] !== '' ? number_format(floatval($row['pcent_APNUR_N_'])*100) : '0') . '%',
            'apnur_am' => $row['points_APNUR_AM_parts'] !== '' ? intval($row['points_APNUR_AM_parts']) : 0,
            'apnur_am_result' => ($row['pcent_APNUR_AM_parts'] !== '' ? number_format(floatval($row['pcent_APNUR_AM_parts'])*100) : '0') . '%',
            'apnur_p' => $row['points_APNUR_P'] !== '' ? intval($row['points_APNUR_P']) : 0,
            'apnur_p_result' => ($row['pcent_APNUR_P'] !== '' ? number_format(floatval($row['pcent_APNUR_P'])*100) : '0') . '%',

            'gp_cpro' => $row['points_GPVAL_'] !== '' ? intval($row['points_GPVAL_']) : 0,
            'gp_cpro_result' => $row['score_GPVAL_'] !== '' ? '$'.intval($row['score_GPVAL_']) : 0,

            'rim' => $row['points_RIM'] !== '' ? intval($row['points_RIM']) : 0,
            'rim_result' => ($row['pcent_RIM'] !== '' ? number_format(floatval($row['pcent_RIM'])*100) : '0') . '%',
        ];
    }
}
