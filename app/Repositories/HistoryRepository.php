<?php

namespace App\Repositories;

use App\Models\History;

class HistoryRepository {


    // get total loyalty before 2019-01-01
    public function getLoyaltyToTheBrandData(?string $employeeCode) {
        return History::where('period', '<', '2019-01-01')
            ->where('member_id', $employeeCode)
            ->sum('amount');
    }

    // get total loyalty until current year
    public function getTotalHistoricalData(?string $employeeCode) {
        $currentYearString = config('app.theme') . '-01-01';
        return History::where('member_id', $employeeCode)
        ->where('period', '<=', $currentYearString)
            ->sum('amount');
    }

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public function getAllHistoricalData(?string $employeeCode) {
        return History::select('period', 'amount')
        ->where('member_id', $employeeCode)
        ->orderBy('period', 'DESC')->get(); //keep orderby
    }
}
