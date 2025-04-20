<?php

namespace App\Services;

use App\Models\{History, User};
use Illuminate\Support\Facades\Auth;

class HistoricalService extends BaseService {

    /**
     * @return array
     */
    public function getHistoricalData(): array {
        /** @var User $currentUser */
        $currentUser = $this->getCurrentUser();
        if (!$currentUser->employee_code) {
            return [
                'all' => [],
                'total' => 0,
                'loyalty_to_brand' => 0
            ];
        }
        $currentYear = date('y', strtotime(config('app.theme')));
        $loyaltyToBrand = History::getLoyaltyToTheBrandData($currentUser->employee_code);
        $all = History::getAllHistoricalData($currentUser->employee_code)->pluck('amount', 'period')
            ->reduce(function ($carry, $value, $key) use ($loyaltyToBrand, $currentYear) {
                $year = date('y', strtotime($key));
                if ($year <= '18') {
                    return data_set($carry, 'PRIOR HISTORY - Loyalty to the brand', number_format($loyaltyToBrand, 0));
                } else if($year < $currentYear) {
                    return data_set($carry, 'FY'.$year.' YTD', number_format($value, 0));
                }
        }, []);

        return [
            'all' => $all,
            'total' => History::getTotalHistoricalData($currentUser->employee_code)
        ];
    }
}
