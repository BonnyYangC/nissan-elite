<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class Technician extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'fft' => 'points_ce_FFT3',
        'fft_result' => 'score_ce_FFT3',

        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',

        'train_partTech' => 'Points_train_partTech',
        'train_partTech_result' => 'training_Q_partTech',
        'train_QuizTech' => 'Points_train_QuizTech',
        'train_QuizTech_result' => 'Pcent_train_QuizTech',
    ];
}
