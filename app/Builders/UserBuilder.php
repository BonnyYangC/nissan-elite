<?php

namespace App\Builders;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class UserBuilder extends Builder
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
  
  public function admin(): self {
    return $this->select('id', 'firstname', 'lastname', 'email', 'mobile', 'region_code')
      ->where('position_code', 'ADMIN')
      ->where('users.active', 1);
  }

  public function regionStaff(): self {
    return $this->select('id', 'firstname', 'lastname', 'email', 'position_code', 'mobile', 'active', 'region_code')
      ->whereIn('position_code', Position::REGION_STAFF_POSITIONS)
      ->where('users.active', 1)->orderBy('firstname')->orderBy('lastname');
  }

  public function activeMember(): self {
    return $this->select('users.id', 'employee_code', 'firstname', 'lastname', 'email', 'position_code', 'users.active', 'dealers.name', 'dealers.state')
      ->join('dealers', 'dealers.code', '=', 'users.dealer_code')
      ->where('users.active', 1);
  }
}