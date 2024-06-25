<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\{Position, Reward};
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
        if (in_array($position, array_merge(Position::TECHNICIAN_POSITIONS, [Role::TECHNICIAN]))) {
            return Reward::factory()->make([
                'commendation' => 1000,
                'bronze' => 2000,
                'silver' => 3000,
                'gold' => 4000,
                'max' => 5000
            ]);
        } else {
            return $this->repository->getRewardsByPosition($position);
        }
    }
}
