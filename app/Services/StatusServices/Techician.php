<?php

namespace App\Services\StatusServices;


class Techician {

    const LEGEND_LEVEL_4       = 'Gold                    Master Techician'; // don't remove space
    const LEGEND_LEVEL_3       = 'Silver                  Master Techician';
    const LEGEND_LEVEL_2       = 'Bronze                Advanced Techician';
    const LEGEND_LEVEL_1       = 'Commendation  Master/Advanced Techician';

    const STATUS_LEVEL_4       = 'Gold';
    const STATUS_LEVEL_3    = 'Silver';
    const STATUS_LEVEL_2      = 'Bronze';
    const STATUS_LEVEL_1        = 'Commendation';

    const STATUS_LEVEL_4_COLOR       = '#FFD700'; //gold
    const STATUS_LEVEL_3_COLOR    = '#C0C0C0'; //silver
    const STATUS_LEVEL_2_COLOR      = '#8B4513'; //SaddleBrown
    const STATUS_LEVEL_1_COLOR        = '#525357';
    const STATUS_LEVEL_DEFAULT_COLOR       = '#000000';


    const MAX_LEVEL_5 = 5000;
    const MAX_LEVEL_4 = 4000;
    const MAX_LEVEL_3 = 3000;
    const MAX_LEVEL_2 = 2000;
    const MAX_LEVEL_1 = 1000;

    const PERCENTAGE_LEVEL_1 = (self::MAX_LEVEL_1/self::MAX_LEVEL_5)*100;
    const PERCENTAGE_LEVEL_2 = (self::MAX_LEVEL_2/self::MAX_LEVEL_5)*100;
    const PERCENTAGE_LEVEL_3 = (self::MAX_LEVEL_3/self::MAX_LEVEL_5)*100;
    const PERCENTAGE_LEVEL_4 = (self::MAX_LEVEL_4/self::MAX_LEVEL_5)*100;
}
