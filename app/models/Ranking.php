<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model {

    use HasFactory;

    const CURRENT           = 'Current';
    const PREVIOUS          = 'Previous';
    const REGIONAL          = 'Regional';
    const STATE             = 'State';
    const NATIONAL          = 'National';

    const AWARD_STATUS      = 'status';
    const AWARD_PLATINUM    = 'platinum';

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public static function getMaxPeriod(string $employeeCode) {
        return Ranking::where('employee_code', $employeeCode)->max('period');
    }

    /**
     * @param string $position
     * @return mixed
     */
    public static function getMaxPeriodByPositionAndCat(string $position) {
        return Ranking::where('position', $position)->max('period');
    }

    /**
     * @param string $position
     * @param string $period
     * @param string $type
     * @param string $state
     * @return mixed
     */
    public static function getRankingsBy(string $position, string $period, string $type, string $state = null) {
        $query = self::join('users','rankings.employee_code', '=', 'users.employee_code')
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code');
        if ($type === self::AWARD_STATUS) {
            $orderBy = 'rank';
            $query = $query->select('users.firstname', 'users.lastname', 'rankings.rank_state', 'rankings.rank', 'rankings.total', 'dealers.name', 'dealers.category');
        } else {
            $orderBy = 'rank_platinum';
            $query = $query->select('users.firstname', 'users.lastname', 'rankings.rank_state', 'rankings.rank_platinum as rank', 'rankings.total_platinum as total', 'dealers.name', 'dealers.category');
        }
        $query = $query->where('rankings.position', $position)
            ->where('period', $period)
            ->orderBy($orderBy);
        if ($state) {
            $query = $query->where('rank_state', $state);
        }
        return $query->get();
    }

    /**
     * @param string $employeeCode
     * @param string $period
     * @return mixed
     */
    public static function getRankingByEmployeeCode(string $employeeCode, string $period) {
        return self::select('rank', 'rank_platinum')
            ->where('employee_code', $employeeCode)
            ->where('period', $period)
            ->get();
    }
}
