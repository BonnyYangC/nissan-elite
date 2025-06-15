<?php

namespace App\Services\MetricsServices\IndividualMetrics;

class Formator {

  public function process($metric, $score) {
    $formatted = 0;
    $scoreDefault = data_get($metric, 'score_default', 0);
    switch (data_get($metric, 'score_format', 'I')) {
        case '%':
            $formatted = $score !== '' ? number_format(floatval($score)*100, data_get($metric, 'score_decimals', 0)) . '%' : $scoreDefault;
            break;
        case '%.100': // percent format but NO need to times 100
            $formatted = $score !== '' ? number_format(floatval($score), data_get($metric, 'score_decimals', 0)) . '%' : $scoreDefault;
            break;
        case '$':
            $formatted = $score !== '' ? '$'.intval($score) : $scoreDefault;
            break;
        case 'f':
            $formatted = $score !== '' ? number_format(floatval($score), data_get($metric, 'score_decimals', 0)) : $scoreDefault;
            break;
        case 'f.100': // float format but DO need to times 100
            $formatted = $score !== '' ? number_format(floatval($score)*100, data_get($metric, 'score_decimals', 0)) : $scoreDefault;
            break;
        case 'b':
            $formatted = $score !== '' ? strtoupper($score) : $scoreDefault;
            break;

        default:
            $formatted = $score !== '' ? intval($score) : $scoreDefault;
            break;
    }
    return $formatted;
  }
}