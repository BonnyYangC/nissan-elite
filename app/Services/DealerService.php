<?php

namespace App\Services;

use App\Models\Dealer;

class DealerService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * get dealer by dealer code
     *
     * @param [string] $dealerCode
     * @return void
     */
    public static function getDealerByCode($dealerCode) {
        return Dealer::where('code', '=', $dealerCode)->first();
    }
}
