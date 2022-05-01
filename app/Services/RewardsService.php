<?php

namespace App\Services;

use App\Models\Ranking;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;

class RewardsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return Reward
     */
    public function buildRewardsData(): Reward {
        $currentUser = Auth::user();
        return $currentUser->position->rewards;
    }
}
