<?php

namespace App\Services;

use App\Models\Reward;

class RewardsService extends BaseService {

    /**
     * @return Reward
     */
    public function buildRewardsData(string $position): Reward {
        return $this->getRewardsByPosition($position);
    }

    // should use repository patten
    private function getRewardsByPosition(string $position) {
        return Reward::where('position', $position)->first();
    }
}
