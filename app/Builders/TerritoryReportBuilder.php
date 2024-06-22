<?php

namespace App\Builders;
use Illuminate\Database\Query\JoinClause;

class TerritoryReportBuilder extends BaseBuilder
{
  public function joinUserEligible() {
    return $this->join('users_eligible', function (JoinClause $join) {
      $join->on('users_eligible.employee_code', '=', 'users.employee_code')
        ->where('users_eligible.year', config('elite.YEAR'));
    });
  }

  public function joinDealerRegions(array $regions) {
    return $this->join('dealer_regions', function (JoinClause $join) use ($regions) {
      $join->on('dealer_regions.code', '=', 'dealers.code')
        ->where('dealer_regions.year', config('elite.YEAR'))
        ->whereIn('region', $regions);
    });
  }
}