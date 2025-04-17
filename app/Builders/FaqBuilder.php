<?php

namespace App\Builders;

class FaqBuilder extends BaseBuilder
{
  public function every(): self {
    return $this;
  }

  public function published(): self {
    return $this->where('status', '=', '1');
  }

  public function draft(): self {
    return $this->where('status', '=', '0');
  }
}