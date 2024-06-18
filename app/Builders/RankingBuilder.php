<?php

namespace App\Builders;

class RankingBuilder extends BaseBuilder
{
  public function position(string $code) {
    return $this->where('position', $code);
  }

  public function employee(string $code) {
    return $this->where('employee_code', $code);
  }
}