<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class RegionBuilder extends Builder
{
  public function territoryRegions(): self {
    return $this->whereIn('code', ['E', 'N', 'S', 'W']);
  }
}