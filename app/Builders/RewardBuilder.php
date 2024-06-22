<?php

namespace App\Builders;

class RewardBuilder extends BaseBuilder
{
  public function byPosition(string $position): self {
    return $this->currentYear()->where('position', $position);
  }
}