<?php

namespace App\Helper;


class State {
    // should seed into db
    const DEALER_STATE_NSW       = 'NSW';
    const DEALER_STATE_ACT       = 'ACT';
    const DEALER_STATE_NT       = 'NT';
    const DEALER_STATE_QLD       = 'QLD';
    const DEALER_STATE_SA       = 'SA';
    const DEALER_STATE_TAS       = 'TAS';
    const DEALER_STATE_VIC       = 'VIC';
    const DEALER_STATE_WA       = 'WA';

    const RANKING_STATE_WA       = 'WA';
    const RANKING_STATE_VIC_TAS       = 'VIC/TAS';
    const RANKING_STATE_SA_NT       = 'SA/NT';
    const RANKING_STATE_QLD       = 'QLD';
    const RANKING_STATE_NSW       = 'NSW';

    const RANKING_STATE_MAPPING = [
        self::DEALER_STATE_NSW => self::RANKING_STATE_NSW,
        self::DEALER_STATE_QLD => self::RANKING_STATE_QLD,
        self::DEALER_STATE_NT => self::RANKING_STATE_SA_NT,
        self::DEALER_STATE_SA => self::RANKING_STATE_SA_NT,
        self::DEALER_STATE_TAS => self::RANKING_STATE_VIC_TAS,
        self::DEALER_STATE_VIC => self::RANKING_STATE_VIC_TAS,
        self::DEALER_STATE_WA => self::RANKING_STATE_WA,
    ];
}
