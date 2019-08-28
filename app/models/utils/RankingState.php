<?php

namespace App\models\utils;

class RankingState {

    //'company state' => 'ranking state'
    const RANKING_STATE_MAP = [
        'NSW' => 'NSW',
        'ACT' => 'NSW',
        'QLD' => 'QLD',
        'SA' => 'SA/NT',
        'NT' => 'SA/NT',
        'VIC' => 'VIC/TAS',
        'TAS' => 'VIC/TAS',
        'WA' => 'WA',
    ];
}