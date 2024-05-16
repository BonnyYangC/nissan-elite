<?php

namespace App\Repositories;

use App\Models\Region;

class RegionRepository {

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
        return Region::territoryRegions()->get();
    }
}
