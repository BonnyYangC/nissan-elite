<?php

namespace App\Repositories;

use App\Models\Incentive;

class IncentiveRepository {

    public function load() {
        return Incentive::get();
    }
}
