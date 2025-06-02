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
        $currentYear = substr(config('app.theme'), -2);
        $loyaltyToBrand = History::getLoyaltyToTheBrandData($currentUser->employee_code);
        $allData = History::getAllHistoricalData($currentUser->employee_code)->pluck('amount', 'period');
        $all = $allData
            ->reduce(function ($carry, $value, $key) use ($loyaltyToBrand, $currentYear) {
                $year = date('y', strtotime($key));
                if ($year <= '18') {
                    return $carry->put('PRIOR HISTORY - Loyalty to the brand', number_format($loyaltyToBrand, 0));
                } else if($year <= $currentYear) {
                    return $carry->put('FY'.$year.' YTD', number_format($value, 0));
                }
        }, collect([]));
        
        $latestYearWithNoData = date('y', strtotime($allData->keys()->first()))+1;
        while ($latestYearWithNoData <= $currentYear) {
            $all->prepend(0, 'FY' . $latestYearWithNoData . ' YTD');
            $latestYearWithNoData++;
        }
        return [
            'all' => $all,
            'total' => History::getTotalHistoricalData($currentUser->employee_code)
        ];
    }
}
