<?php

namespace App\Builders;

class ResultBuilder extends BaseBuilder
{
  public function byPosition(string $position): self {
    return $this->where('position', $position);
  }

  public function yearToDate(string $employee_code, string $position): self {
    return $this->currentYear()
      ->byPosition($position)
      ->where('employee_code', $employee_code);
  }
}