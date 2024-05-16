<?php

namespace App\Builders;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class IncentiveBuilder extends Builder
{
  public function loadAll(): self {
    return $this;
  }

    /**
     * @param null $region
     * @return mixed
     */
    public function current($region = null): self {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $region = self::getRegion($region);
        return self::where('start', '<=', $today->format('Y-m-d'))
            ->where('finish', '>=', $today->format('Y-m-d'))
            ->whereIn('region', $region)
            ->orderBy('start', 'DESC');
    }

    /**
     * @param null $region
     * @return mixed
     */
    public function finished($region = null): self {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $threeMonthsBefore = Carbon::now()->subMonths(3);
        $region = self::getRegion($region);
        return self::whereBetween('finish', [$threeMonthsBefore->format('Y-m-d'), $today->format('Y-m-d')])
            ->whereIn('region', $region)
            ->orderBy('start', 'DESC');
    }

    /**
     * @param null $region
     * @return mixed
     */
    public function past($region = null): self {
        $threeMonthsBefore = Carbon::now()->subMonths(3);
        $region = self::getRegion($region);
        return self::where('finish', '<', $threeMonthsBefore->format('Y-m-d'))
          ->whereIn('region', $region)
          ->orderBy('start', 'DESC');
    }

    /**
     * @param null $region
     * @return mixed
     */
    public function upComing($region = null): self {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $region = self::getRegion($region);
        return self::where('start', '>', $today->format('Y-m-d'))
          ->whereIn('region', $region)
          ->orderBy('start', 'ASC');
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