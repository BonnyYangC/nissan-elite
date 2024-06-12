<?php

namespace App\Builders;
use App\Models\AwardsType;

class AwardBuilder extends BaseBuilder
{
  public function national(): self {
    return $this->currentYear()->where('type', AwardsType::PLATINUM_NATIONAL);
  }

  public function state(): self {
    return $this->currentYear()->where('type', AwardsType::PLATINUM_STATE);
  }

  public function gold(): self {
    return $this->currentYear()->where('type', AwardsType::GOLD_STATUS);
  }
}