<?php

namespace App\Repositories;

use App\Models\Result;

class ResultRepository {
    function getMetricsPointsByPosition(string $employeeCode, string $positionCode) {
        return Result::yearToDate($employeeCode, $positionCode)
            ->get();
    }
}
