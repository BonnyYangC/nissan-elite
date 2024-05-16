<?php

namespace App\Builders;
use Illuminate\Database\Eloquent\Builder;

class RewardBuilder extends BaseBuilder
{
  public function byPosition(string $position): self {
    return $this->currentYear()->where('position', $position);
  }
}