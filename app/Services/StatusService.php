<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\Position;
use App\Models\Reward;
use App\Services\StatusServices\Current;
use App\Services\StatusServices\GageStatus;
use App\Services\StatusServices\Techician;

class StatusService extends BaseService {

    /**
     * @param string $completed
     * @param string|null $position
     * @return GageStatus
     */
    public function getStatus(string $completed, string $position = null) {
        if (!$position) {
            $position = $this->currentUser->position;
            $position = $position->code;
        }
        $rewards = Reward::byPosition($position)->first();
        if (in_array($position, array_merge(Position::TECHNICIAN_POSITIONS, [Role::TECHNICIAN]))) {
        //     $rewards = Reward::factory()->make([
        //         'commendation' => 1000,
        //         'bronze' => 2000,
        //         'silver' => 3000,
        //         'gold' => 4000,
        //         'max' => 5000
        //     ]);
            return new Techician($rewards, $completed, $position);
        } else {
            return new Current($rewards, $completed);
        }
        // return new GageStatus($rewards, $ytd);
    }

    /**
     * @param string $completed
     * @return array
     */
    public function buildStatusData(string $completed): array {
        $status = $this->getStatus($completed);
        return [
            'gageArray'=>$status->indicators,
            // 'color'=>$status->getColor(),
            'colorText'=>$status->colorText,
            'toReach'=>$status->toReach,
            // 'min'=>$status->getMin(),
            'max'=>$status->max,
        ];

    }
}
