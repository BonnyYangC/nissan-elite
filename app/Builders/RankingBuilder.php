<?php

namespace App\Builders;
use Illuminate\Database\Query\JoinClause;

class RankingBuilder extends BaseBuilder
{
  public function position(string $code) {
    return $this->where('position', $code);
  }

  public function employee(string $code) {
    return $this->where('employee_code', $code);
  }

  public function joinUserEligible() {
    return $this->join('users_eligible', function (JoinClause $join) {
      $join->on('users_eligible.employee_code', '=', 'rankings.employee_code')
        ->where('users_eligible.year', config('elite.YEAR'));
    });
  }

  public function joinDealerRegions() {
    return $this->join('dealer_regions', function (JoinClause $join) {
      $join->on('dealer_regions.code', '=', 'dealers.code')
        ->where('dealer_regions.year', config('elite.YEAR'));
    });
  }
}