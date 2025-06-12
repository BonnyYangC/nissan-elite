<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\HistoryRepository;
use App\Traits\User as UserTrait;

class HistoricalService {

    use UserTrait;

    protected $repository;

    public function __construct(HistoryRepository $historyRepository) {
        $this->repository = $historyRepository;
    }

    public function getHistoricalData($ytd): array {
        /** @var User $currentUser */
        $currentUser = $this->getCurrentUser();
        $currentYear = substr(config('app.theme'), -2);
        return [
            'all' => $this->buildHistoricalData($currentYear, $currentUser->employee_code, $ytd),
            'total' => $this->repository->getTotalHistoricalData($currentUser->employee_code)
        ];
    }

    private function buildHistoricalData($currentYear, $employeeCode, $ytd) {
        $historicalData = $this->repository->getAllHistoricalData($employeeCode)->pluck('amount', 'period')->keyBy(function ($value, $key) {
            return date('y', strtotime($key));
        });
        $loyaltyToBrand = $this->repository->getLoyaltyToTheBrandData($employeeCode);
        return collect(range((int) '18', (int) $currentYear))->reduce(function ($carry, $year) use ($currentYear, $historicalData, $loyaltyToBrand, $ytd) {
            if ($year == $currentYear) {
                return $carry->prepend(number_format($ytd, 0), 'FY' . $year . ' YTD');
            } else if ($year > '18') {
                return $carry->prepend(number_format(data_get($historicalData, $year, 0), 0), 'FY' . $year . ' YTD');
            } else {
                return $carry->put('PRIOR HISTORY - Loyalty to the brand', number_format($loyaltyToBrand, 0));
            }
        }, collect());
    }
}
