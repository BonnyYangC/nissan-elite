<?php

namespace App\Models;

use App\Helper\State;
use Carbon\Carbon;
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
     * @return Carbon|false
     */
    public static function getMaxPeriodByPositionAndCat(string $position) {
        $result = Ranking::where('position', $position)->max('period');
        return Carbon::createFromFormat('Y-m-d',$result);
    }

    /**
     * @param string $position
     * @param string $period
     * @param string $type
     * @param int|null $take
     * @param string|null $state
     * @return mixed
     */
    public static function getRankingsBy(string $position, string $period, string $type, int $take = null, string $state = null) {
        $query = self::join('users','rankings.employee_code', '=', 'users.employee_code')
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->select('users.employee_code', 'users.firstname', 'users.lastname', 'users.registered', 'rankings.rank_state', 'dealers.name', 'dealers.category', 'dealers.state');
        if ($type === self::AWARD_STATUS) {
            $orderBy = 'rank';
            $query = $query->addSelect('rankings.rank', 'rankings.total');
        } else {
            $orderBy = 'rank_platinum';
            $query = $query->addSelect('rankings.rank_platinum as rank', 'rankings.total_platinum as total');
        }
        $query = $query->where('users.active', '=', 1)->where('rankings.position', $position)
            ->where('period', $period)
            ->orderBy('rank_state')->orderBy($orderBy);
        if ($state) {
            $query = $query->where('rank_state', State::RANKING_STATE_MAPPING[$state]);
        }
        if ($take && $take > 0) {
            $query = $query->take($take);
        }
        return $query->get();
    }

    /**
     * @param string $employeeCode
     * @param string $period
     * @param string $type
     * @return mixed
     */
    public static function getRankingByEmployeeCode(string $employeeCode, string $period, string $type) {
        $query = self::join('users','rankings.employee_code', '=', 'users.employee_code')
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->select('users.employee_code', 'users.firstname', 'users.lastname', 'users.registered', 'rankings.rank_state', 'dealers.name', 'dealers.category', 'dealers.state');
        if ($type === self::AWARD_STATUS) {
            $orderBy = 'rank';
            $query = $query->addSelect('rankings.rank', 'rankings.total');
        } else {
            $orderBy = 'rank_platinum';
            $query = $query->addSelect('rankings.rank_platinum as rank', 'rankings.total_platinum as total');
        }
        return $query->where('users.employee_code', $employeeCode)
            ->where('period', $period)->orderBy($orderBy)
            ->get();
    }

    /**
     * @param string $employeeCode
     * @param string $period
     * @return mixed
     */
    public static function getRankByEmployeeCode(string $employeeCode, string $period) {
        return self::select('rank', 'rank_platinum')
            ->where('employee_code', $employeeCode)
            ->where('period', $period)
            ->get();
    }
}
