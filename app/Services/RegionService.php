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

    /**
     * @return mixed
     */
    public function getTerritoryReportRegions() {
        return Region::whereIn('code', ['E', 'N', 'S', 'W'])->get();
    }
}
