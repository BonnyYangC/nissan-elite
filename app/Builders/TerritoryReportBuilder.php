<?php

namespace App\Builders;
use Illuminate\Database\Query\JoinClause;

class TerritoryReportBuilder extends BaseBuilder
{
  public function joinUserEligible() {
    return $this->join('users_eligible', function (JoinClause $join) {
      $join->on('users_eligible.employee_code', '=', 'users.employee_code');
    });
  }

  public function joinDealerRegions(array $regions) {
    return $this->join('dealer_regions', function (JoinClause $join) use ($regions) {
      $join->on('dealer_regions.code', '=', 'dealers.code')
        ->whereIn('region', $regions);
    });
  }
}