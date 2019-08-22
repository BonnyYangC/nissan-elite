<?php

namespace App\models\role\status;

class LoyaltyStatus
{
    const STATUS_LEVEL_4       = 'Platinum';
    const STATUS_LEVEL_3    = 'Gold';
    const STATUS_LEVEL_2      = 'Silver';
    const STATUS_LEVEL_1        = 'Bronze';

    const STATUS_LEVEL_4_COLOR       = '#545454'; //Platinum
    const STATUS_LEVEL_3_COLOR    = '#CD7F32'; //Gold
    const STATUS_LEVEL_2_COLOR      = '#C0C0C0'; //Silver
    const STATUS_LEVEL_1_COLOR        = '#8C7853'; //Bronze

    const MAX_LEVEL_4 = 500000;
    const MAX_LEVEL_3 = 325000;
    const MAX_LEVEL_2 = 200000;
    const MAX_LEVEL_1 = 100000;
}