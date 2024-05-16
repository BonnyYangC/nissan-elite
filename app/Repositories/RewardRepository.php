<?php

namespace App\Repositories;

use App\Models\Reward;

class RewardRepository {

    public function getRewardsByPosition(string $position) {
        return Reward::byPosition($position)->first();
    }
}
