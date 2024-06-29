<?php

namespace App\Models;

use App\Builders\RankingBuilder;
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

    public function newEloquentBuilder($query): RankingBuilder {
        return new RankingBuilder($query);
    }

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public static function getMaxPeriod(string $employeeCode, string $positionCode) {
        return Ranking::currentYear()->where('employee_code', $employeeCode)
            ->where('position', $positionCode)
            ->max('period');
    }

    /**
     * @param string $positions
     * @return Carbon|false
     */
    public static function getMaxPeriodByPositionAndCat(array $positions) {
        $result = Ranking::currentYear()->whereIn('position', $positions)
            ->max('period');
        return Carbon::createFromFormat('Y-m-d',$result);
    }

    public static function getNationalRankingsBy(array $positions, string $period, int $take = null) {

        $query = self::where('period', $period)->whereIn('rankings.position', $positions);

        $query = $query->join('users','rankings.employee_code', '=', 'users.employee_code')
            ->joinUserEligible()
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->joinDealerRegions()
            ->select('users.employee_code', 'users.firstname', 'users.lastname', 'users_eligible.registered', 'rankings.position', 'dealers.state', 'dealers.name', 'dealer_regions.category', 'dealers.state as dealer_state');

        $query = $query->addSelect('rankings.rank', 'rankings.total');

        if ($take && $take > 0) {
            $query = $query->take($take);
        }
        return $query->orderBy('position', 'desc')->orderBy('rank')->orderBy('state')->get();
    }

    public static function getRankingsBy(array $positions, string $period, string $type, int $take = null, string $state = null) {

        $query = self::where('users.active', '=', 1)->whereIn('rankings.position', $positions)
            ->where('period', $period);
        if ($state) {
            $query = $query->where('rank_state', State::RANKING_STATE_MAPPING[$state]);
        }

        $query = $query->join('users','rankings.employee_code', '=', 'users.employee_code')
            ->joinUserEligible()
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->joinDealerRegions()
            ->select('users.employee_code', 'users.firstname', 'users.lastname', 'users_eligible.registered', 'rankings.position', 'rankings.rank_state as state', 'dealers.name', 'dealer_regions.category', 'dealers.state as dealer_state');
        if ($type === self::AWARD_STATUS) {
            $orderBy = 'rank';
            $query = $query->addSelect('rankings.rank', 'rankings.total');
        } else {
            $orderBy = 'rank_platinum';
            $query = $query->addSelect('rankings.rank_platinum as rank', 'rankings.total_platinum as total');
        }
        if ($take && $take > 0) {
            $query = $query->take($take);
        }
        return $query->orderBy('position')->orderBy('state')->orderBy('rank')->get();
    }

    /**
     * @param string $employeeCode
     * @param string $period
     * @param string $type
     * @return mixed
     */
    public static function getRankingByEmployeeCode(string $employeeCode, string $period, string $type = Ranking::AWARD_STATUS) {
        $query = self::where('users.employee_code', $employeeCode)
            ->where('period', $period);
        $query = $query->join('users', 'rankings.employee_code', '=', 'users.employee_code')
            ->joinUserEligible()
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->joinDealerRegions()
            ->select('users.employee_code', 'users.firstname', 'users.lastname', 'users_eligible.registered', 'rankings.rank_state', 'dealers.name', 'dealer_regions.category', 'dealers.state as dealer_state');
        if ($type === self::AWARD_STATUS) {
            $orderBy = 'rank';
            $query = $query->addSelect('rankings.rank', 'rankings.total');
        } else {
            $orderBy = 'rank_platinum';
            $query = $query->addSelect('rankings.rank_platinum as rank', 'rankings.total_platinum as total');
        }
        return $query->orderBy($orderBy)
            ->get();
    }

    /**
     * @param string $employeeCode
     * @param string $period
     * @return mixed
     */
    public static function getRankOnlyByEmployeeCode(string $employeeCode, string $period) {
        return self::select('rank', 'rank_platinum')
            ->where('employee_code', $employeeCode)
            ->where('period', $period)
            ->get();
    }
}
