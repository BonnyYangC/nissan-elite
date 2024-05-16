<?php

namespace App\Services;

use App\Models\Reward;
use App\Services\StatusServices\GageStatus;

class StatusService extends BaseService {

    /**
     * @param string $ytd
     * @param string|null $position
     * @return GageStatus
     */
    public function getStatus(string $ytd, string $position = null) {
        if (!$position) {
            $position = $this->currentUser->position;
        }
        $rewards = Reward::byPosition($position->code)->first();
        return new GageStatus($rewards->commendation, $rewards->bronze, $rewards->silver, $rewards->gold, $ytd, $rewards->max);
    }

    /**
     * @param string $ytd
     * @return array
     */
    public function buildStatusData(string $ytd): array {
        $status = $this->getStatus($ytd);
        return [
            'gageArray'=>$status->getGageIndicators(),
            'color'=>$status->getColor(),
            'colorText'=>$status->getColorText(),
            'toReach'=>$status->getToReach(),
            'min'=>$status->getMin(),
            'max'=>$status->getMax(),
        ];

    }
}
