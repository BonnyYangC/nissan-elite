<?php

namespace App\Services;

use App\Models\Reward;

class RewardsService extends BaseService {

    /**
     * @return Reward
     */
    public function buildRewardsData(): Reward {
        return $this->currentUser->position->rewards;
    }
}
