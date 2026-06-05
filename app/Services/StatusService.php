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

//var_dump('3333', $position);
        $rewards = Reward::byPosition($position)->first();
//var_dump('4444', $position, json_encode($rewards));
	if (in_array($position, array_merge(Position::TECHNICIAN_POSITIONS, [Role::TECHNICIAN]))) {
            return new Techician($rewards, $completed, $position);
        } else {
            return new Current($rewards, $completed);
        }
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
