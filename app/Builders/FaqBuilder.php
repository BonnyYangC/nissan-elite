<?php

namespace App\Builders;

class FaqBuilder extends BaseBuilder
{
  public function every(): self {
    return $this->currentYear();
  }

  public function published(): self {
    return $this->currentYear()->where('status', '=', '1');
  }

  public function draft(): self {
    return $this->currentYear()->where('status', '=', '0');
  }
}