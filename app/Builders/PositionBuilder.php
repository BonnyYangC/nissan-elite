<?php

namespace App\Builders;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;

class PositionBuilder extends Builder
{
  public function members(): self {
    return $this->whereIn('department', ['Sales', 'Parts', 'Service', 'Administration']);
  }
  
  public function regionStaffs(): self {
    return $this->whereIn('code', Position::REGION_STAFF_POSITIONS);
  }
}