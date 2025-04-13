<?php

namespace App\Services;

use App\Helper\Utility;
use App\Models\Result;

class ResultService extends BaseService {

    /**
     * @return false|string
     */
    public function buildMonthlyData(string $positionCode) {
        $results = $this->getResultsByPosition($this->currentUser->employee_code, $positionCode);
        $resultsData = $results->reduce(function ($r, $result) {
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

    // should use repository patten
    private function getResultsByPosition(string $employeeCode, string $position) {
        return Result::where('employee_code', $employeeCode)
            ->where('position', $position)
            ->where('year', config('app.theme'))
            ->get();
    }

    /**
     * @return mixed
     */
    public function getYearToDateData(string $position) {
        $employeeCode = $this->currentUser->employee_code;
        return $employeeCode ? Result::yearToDate($employeeCode, $position)
            ->max('credit_ytd') : 0;
    }
}
