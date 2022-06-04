<?php

namespace App\Services;

use App\Helper\Utility;
use App\Models\Result;

class ResultService extends BaseService {

    /**
     * @return false|string
     */
    public function buildResultsData() {
        $resultsData = $this->currentUser->results()->reduce(function ($r, $result) {
            $r[date("M", strtotime($result->period))] = $result->credit_mtd;
            return $r;
        }, array_reduce(Utility::MONTHS_SHORT, function ($r, $key) {
            $r[$key] = floatval(0);
            return $r;
        }, []));
        $chartData = [['Month', 'Points']];
        foreach ($resultsData as $key => $value) {
            $chartData[] = [$key, $value];
        }
        return json_encode($chartData);

    }

    /**
     * @return mixed
     */
    public function getYearToDateData() {
        return Result::where('employee_code', $this->currentUser->employee_code)->max('credit_ytd');
    }
}
