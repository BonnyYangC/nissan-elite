<?php

namespace App\Services;

use App\Models\TerritoryReport;

class TerritoryReportService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @param array $regions
     * @param string $dept
     * @param null $dealerNameKeyword
     * @return mixed
     */
    public function load(array $regions, $dept = 'All', $dealerNameKeyword = null){
        $query = TerritoryReport::where('territory_reports.year', config('elite.YEAR'))
            ->join('users', 'territory_reports.employee_code', '=', 'users.employee_code')
            ->joinUserEligible()
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->joinDealerRegions($regions)
            ->join('positions', 'users.position_code', '=', 'positions.code')
            ->join('regions', 'regions.code', '=', 'dealer_regions.region')
            ->select('users.id', 'dealers.name as d', 'users_eligible.registered as c', 'users.position_code', 'users.employee_code as e',
            'users.firstname', 'users.lastname', 'positions.title as p', 'positions.department as s', 'cr_ytd as y', 'regions.title as region',
            'award_status as as', 'cr_ytd_lifetime as pys',
            'credits_monthly_04 as c04','credits_monthly_05 as c05','credits_monthly_06 as c06','credits_monthly_07 as c07',
            'credits_monthly_08 as c08','credits_monthly_09 as c09','credits_monthly_10 as c10','credits_monthly_11 as c11',
            'credits_monthly_12 as c12','credits_monthly_01 as c01','credits_monthly_02 as c02','credits_monthly_03 as c03')
            ;

        if ($dept !== 'All') {
            $query = $query->where('positions.department', $dept);
        }
        if ($dealerNameKeyword) {
            $query = $query->where('dealers.name', 'LIKE', '%'.trim($dealerNameKeyword).'%');
        }
        $rows = $query->get();
        return $rows->each(function($r) {
            $r['f'] = $r['firstname'] . ' ' . $r['lastname'];
            $r['c'] = $r['c'] ? 'YES' : 'NO';
        })->all();
    }
}

