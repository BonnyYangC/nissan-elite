<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model {
    use HasFactory;

    public $table = 'nissan_incentives';


    /**
     * @param null $region
     * @return mixed
     */
    public static function getCurrent($region = null) {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $region = self::getRegion($region);
        return self::where('start', '<=', $today->format('Y-m-d'))
            ->where('finish', '>=', $today->format('Y-m-d'))
            ->whereIn('region', $region)
            ->orderBy('start', 'DESC')
            ->get();
    }

    /**
     * @param null $region
     * @return mixed
     */
    public static function getFinished($region = null) {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $threeMonthsBefore = Carbon::now()->subMonths(3);
        $region = self::getRegion($region);
        return self::whereBetween('finish', [$threeMonthsBefore->format('Y-m-d'), $today->format('Y-m-d')])
            ->whereIn('region', $region)
            ->orderBy('start', 'DESC')
            ->get();
    }

    /**
     * @param null $region
     * @return mixed
     */
    public static function getPast($region = null) {
        $threeMonthsBefore = Carbon::now()->subMonths(3);
        $region = self::getRegion($region);
        return self::where('finish', '<', $threeMonthsBefore->format('Y-m-d'))
            ->whereIn('region', $region)
            ->orderBy('start', 'DESC')
            ->get();
    }

    /**
     * @param null $region
     * @return mixed
     */
    public static function getUpComing($region = null) {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $region = self::getRegion($region);
        return self::where('start', '>', $today->format('Y-m-d'))
            ->whereIn('region', $region)
            ->orderBy('start', 'ASC')
            ->get();
    }

    /**
     * @param null $region
     * @return array|null
     */
    private static function getRegion($region = null) {
        if (!$region) {
            $region = [Region::REGION_ALL, Region::REGION_EASTERN, Region::REGION_NORTHERN, Region::REGION_WESTERN, Region::REGION_SOUTHERN];
        } else {
            $region = array_unique(array_merge($region, [Region::REGION_ALL]));
        }
        return $region;
    }
}
