<?php

namespace App\Services\StatusServices;


class Loyalty {
    const STATUS_LEVEL_4       = 'Platinum';
    const STATUS_LEVEL_3    = 'Gold';
    const STATUS_LEVEL_2      = 'Silver';
    const STATUS_LEVEL_1        = 'Bronze';

    const STATUS_LEVEL_4_COLOR       = '#545454'; //Platinum
    const STATUS_LEVEL_3_COLOR    = '#CD7F32'; //Gold
    const STATUS_LEVEL_2_COLOR      = '#C0C0C0'; //Silver
    const STATUS_LEVEL_1_COLOR        = '#8C7853'; //Bronze

    const MAX_LEVEL_4 = 850000;
    const MAX_LEVEL_3 = 500000;
    const MAX_LEVEL_2 = 325000;
    const MAX_LEVEL_1 = 200000;

    const PERCENTAGE_LEVEL_1 = (self::MAX_LEVEL_1/self::MAX_LEVEL_4)*100;
    const PERCENTAGE_LEVEL_2 = (self::MAX_LEVEL_2/self::MAX_LEVEL_4)*100;
    const PERCENTAGE_LEVEL_3 = (self::MAX_LEVEL_3/self::MAX_LEVEL_4)*100;
    const PERCENTAGE_LEVEL_4 = (self::MAX_LEVEL_4/self::MAX_LEVEL_4)*100;
}
