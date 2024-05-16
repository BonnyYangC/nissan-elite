<?php

namespace App\Services;

use App\Models\Reward;
use App\Repositories\RewardRepository;

class RewardsService {

    private $repository;

    public function __construct(RewardRepository $rewardRepository) {
        $this->repository = $rewardRepository;
     }

    /**
     * @return Reward
     */
    public function buildRewardsData(string $position): Reward {
        return $this->repository->getRewardsByPosition($position);
    }
}
