<?php

namespace App\Services;

use App\Models\{History, User};
use Illuminate\Support\Facades\Auth;

class HistoricalService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return array
     */
    public function getHistoricalData(): array {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        if (!$currentUser->employee_code) {
            return [
                'all' => [],
                'total' => 0,
                'loyalty_to_brand' => 0
            ];
        }
        return [
            'all' => History::getAllHistoricalData($currentUser->employee_code)->pluck('amount', 'period')->all(),
            'total' => History::getTotalHistoricalData($currentUser->employee_code),
            'loyalty_to_brand' => History::getLoyaltyToTheBrandData($currentUser->employee_code)
        ];
    }
}
