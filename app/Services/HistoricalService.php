<?php

namespace App\Services;

use App\Models\History;
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
        $currentUser = Auth::user();
        return [
            'all' => History::getAllHistoricalData($currentUser->employee_code)->pluck('amount', 'period')->all(),
            'total' => History::getTotalHistoricalData($currentUser->employee_code),
            'loyalty_to_brand' => History::getLoyaltyToTheBrandData($currentUser->employee_code)
        ];
    }
}
