<?php

namespace App\Services;

use App\Helper\Utility;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return false|string
     */
    public function buildResultsData() {
        $currentUser = Auth::user();

        $resultsData = $currentUser->results()->reduce(function ($r, $result) {
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
        $currentUser = Auth::user();
        return Result::where('employee_code', $currentUser->employee_code)->max('credit_ytd');
    }
}
