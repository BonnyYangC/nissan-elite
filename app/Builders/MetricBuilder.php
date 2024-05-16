<?php

namespace App\Builders;

class MetricBuilder extends BaseBuilder
{
  public function byPosition(string $position): self {
    return $this->where('position', $position);
  }

  public function definations(string $employee_code, string $position): self {
    return $this->currentYear()
      ->where('employee_code', $employee_code)
      ->byPosition($position);
  }
}