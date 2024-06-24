<?php

namespace App\Builders;

use App\Helper\Role;
use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;

class PositionBuilder extends Builder
{
  public function membersWithT(): self {
    return $this->whereIn('code', array_merge(Position::SEARCHABLE_POSITIONS, [Role::TECHNICIAN]));
  }

  public function members(): self {
    return $this->whereIn('code', array_merge(Position::SEARCHABLE_POSITIONS, Position::TECHNICIAN_POSITIONS));
    // return $this->whereIn('department', ['Sales', 'Parts', 'Service', 'Service Tech', 'Administration']);
  }
  
  public function regionStaffs(): self {
    return $this->whereIn('code', Position::REGION_STAFF_POSITIONS);
  }
}