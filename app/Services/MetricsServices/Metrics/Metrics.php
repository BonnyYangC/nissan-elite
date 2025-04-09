<?php

namespace App\Services\MetricsServices\Metrics;

class Metrics {
    private $position;

    public function get($serviceResolver) {
        // switch ($position) {
        //     case Role::PARTS_SALES_REP:
        //         return new MS\PartsSalesRep($this->serviceResolver);
        //     case Role::FLEET_SALES_EXECUTIVES:
        //         return new MS\FleetSalesExecutives($this->serviceResolver);
        //     default:
        //         return new MS\Individual($this->serviceResolver);
        // }
        return new Individual($serviceResolver); 
    }

    public function byPosition($value) {
        $this->position = $value;
        return $this;
    }

}