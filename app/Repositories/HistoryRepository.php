<?php

namespace App\Repositories;

use App\Models\History;

class HistoryRepository {


    /**
     * @param string $employeeCode
     * @return mixed
     */
    public function getLoyaltyToTheBrandData(?string $employeeCode) {
        return History::where('period', '<', '2019-01-01')
            ->where('member_id', $employeeCode)
            ->sum('amount');
    }

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public function getTotalHistoricalData(?string $employeeCode) {
        return History::where('member_id', $employeeCode)
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
