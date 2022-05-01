<?php

namespace App\Services;

use App\Models\Reward;
use App\Services\StatusServices\GageStatus;
use Illuminate\Support\Facades\Auth;

class StatusService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @param string $ytd
     * @param string|null $position
     * @return GageStatus
     */
    public function getStatus(string $ytd, string $position = null) {
        if (!$position) {
            $currentUser = Auth::user();
            $rewards = $currentUser->position->rewards;
        } else {
            $rewards = Reward::where('position', $position)->first();
        }
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
