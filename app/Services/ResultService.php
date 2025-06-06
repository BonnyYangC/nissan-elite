<?php

namespace App\Services;

use App\Helper\Utility;
use App\Models\Result;
use App\Repositories\ResultRepository;
use App\Traits\User as UserTrait;

class ResultService {

    use UserTrait;

    private $repository;

    public function __construct(ResultRepository $resultRepository) {
        $this->repository = $resultRepository;
    }

    public function buildMonthlyData(string $positionCode) {
        $results = $this->repository->getResultsByPosition($this->getCurrentUser()->employee_code, $positionCode);
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

    /**
     * @return mixed
     */
    public function getYearToDateData(string $position) {
        $employeeCode = $this->getCurrentUser()->employee_code;
        return $employeeCode ? Result::yearToDate($employeeCode, $position)
            ->max('credit_ytd') : 0;
    }
}
