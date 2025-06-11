<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoyaltyHistorical {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     *
     */
    public function export() {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $query = "
            SELECT
                r.employee_code,
                concat(u.firstname,' ',u.lastname) AS NAME,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period<'2019-01-01') AS loyaly2brand,
                r.total AS this_year,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2019-01-01') AS fy19,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2020-01-01') AS fy20,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2021-01-01') AS fy21,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2022-01-01') AS fy22,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2023-01-01') AS fy23,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2024-01-01') AS fy24,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2025-01-01') AS fy25,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2026-01-01') AS fy26,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2027-01-01') AS fy27,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code AND h.period='2028-01-01') AS fy28,
                (select SUM(amount) FROM nissan_elite_production.nissan_history h WHERE h.member_id=r.employee_code)+r.total AS total_points_hist
                    FROM rankings r
                    left JOIN users u ON u.employee_code=r.employee_code
                    WHERE r.period=(select max(period) FROM rankings)
                ORDER BY convert(r.employee_code, UNSIGNED)
            ";
        $data = DB::select(DB::raw($query));

        $contentMap = [
            'Member id' => 'employee_code',
            'Name' => 'NAME',
            'loyaly2brand' => 'loyaly2brand',
            'this_year' => 'this_year',
            'fy19' => 'fy19',
            'fy20' => 'fy20',
            'fy21' => 'fy21',
            'fy22' => 'fy22',
            'fy23' => 'fy23',
            'fy24' => 'fy24',
            'fy25' => 'fy25',
            'fy26' => 'fy26',
            'fy27' => 'fy27',
            'fy28' => 'fy28',
            'total_points_hist' => 'total_points_hist'
        ];

        return Utility::exportToFile('nissan_historical_'.$today->format('d_M_Y').'.csv', $data, $contentMap);
    }

}
