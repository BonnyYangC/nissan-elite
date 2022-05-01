<?php

namespace App\Services;

use App\Models\Region;

class RegionService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return
     */
    public function load() {
        return Region::get();
    }
}
