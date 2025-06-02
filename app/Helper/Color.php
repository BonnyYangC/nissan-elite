<?php

namespace App\Helper;

use App\Models\Metric;

class Color {
    const COLOR_1 = "#3366CC";
    const COLOR_2 = "#DC3912";
    const COLOR_3 = "#FF9900";
    const COLOR_4 = "#109618";
    const COLOR_5 = "#990099";
    const COLOR_6 = "#3B3EAC";
    const COLOR_7 = "#0099C6";
    const COLOR_8 = "#DD4477";
    const COLOR_9 = "#66AA00";
    const COLOR_10 = "#B82E2E";
    const COLOR_11 = "#316395";
    const COLOR_12 = "#994499";  //Online
    const COLOR_13 = "#22AA99";  //Pathway
    const COLOR_14 = "#AAAA11";  //Competency
    const COLOR_15 = "#6633CC";  //Bonus
    const COLOR_16 = "#E67300";  //Mastery
    const COLOR_17 = "#8B0707";  //training in stacked chart
    const COLOR_18 = "#329262";  //excellence
    const COLOR_19 = "#5574A6";  //registration
    const COLOR_20 = "#3B3EAC";  //incentive

    const COLOR_PREFIX = 'COLOR_';
    const TRAINING_COLOR_BASE = 17;
    const SHARED_METRICS_COLOR_BASE = 17;
    static function getColor(int $index, string $type) {
        $color = null;
        switch ($type) {
            case Metric::METRICS_TYPE_SHARED:
                $color = constant('self::' . self::COLOR_PREFIX . intVal($index+self::SHARED_METRICS_COLOR_BASE));
                break;
            case Metric::METRICS_TYPE_TRAINING:
                $color = constant('self::' . self::COLOR_PREFIX . self::TRAINING_COLOR_BASE);
                break;
            default:
                $color = constant('self::' . self::COLOR_PREFIX . $index);
                break;
        }
        return $color;
    }
}
