<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\HistoryRepository;
use App\Traits\User as UserTrait;

class LoyaltyService {

    use UserTrait;

    protected $repository;

    public function __construct(HistoryRepository $historyRepository) {
        $this->repository = $historyRepository;
    }

    public function buildLoyaltyData($ytd): array {
        /** @var User $currentUser */
        $currentUser = $this->getCurrentUser();
        $currentYear = substr(config('app.theme'), -2);
        $loyaltyStringToLastYear = $this->buildLoyaltyStringToLastYear(intval($currentYear)-1, $currentUser->employee_code);
        return [
            'all' => $loyaltyStringToLastYear->prepend(
                number_format($ytd, 0), 'FY' . $currentYear . ' YTD'
            ),
            'total' => $this->repository->getLoyaltyToLastYear($currentUser->employee_code)+$ytd
        ];
    }

    private function buildLoyaltyStringToLastYear($lastYear, $employeeCode) {
        $historicalData = $this->repository->getAllHistoricalData($employeeCode)
            ->pluck('amount', 'period')
            ->keyBy(function ($value, $key) {
                return date('y', strtotime($key));
            });
        $loyaltyToBrand = $this->repository->getLoyaltyToTheBrandData($employeeCode);
        return collect(range((int) '18', (int) $lastYear))->reduce(function ($carry, $year) use ($historicalData, $loyaltyToBrand) {
            if ($year > '18') {
                return $carry->prepend(number_format(data_get($historicalData, $year, 0), 0), 'FY' . $year . ' YTD');
            } else {
                return $carry->put('PRIOR HISTORY - Loyalty to the brand', number_format($loyaltyToBrand, 0));
            }
        }, collect());
    }
}
