<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class Technician extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        // as new points_ce_dlr_D1_AS starts from OCT, need to Backward compatibility with Apr ~ Sep data (points_ce_FFT3)
        'f1' => 'points_ce_dlr_D1_AS_TECH', //'points_ce_FFT3',
        'f1_result' => 'score_ce_dlr_D1_AS_TECH', //'score_ce_FFT3',

        // as new points_ce_dlr_5Star_AS starts from OCT, need to Backward compatibility with Apr ~ Sep data (points_ce_SOS3)
        '5_star' => 'points_ce_dlr_5Star_AS_TECH', //'points_ce_SOS3',
        '5_star_result' => 'score_ce_dlr_5Star_AS_TECH', //'score_ce_SOS3',

        'train_partTech' => 'Points_train_partTech',
        'train_partTech_result' => 'training_Q_partTech',
        'train_QuizTech' => 'Points_train_QuizTech',
        'train_QuizTech_result' => 'Pcent_train_QuizTech',

    ];
}
