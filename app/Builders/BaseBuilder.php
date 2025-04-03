<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class BaseBuilder extends Builder
{
  public function currentYear(): self {
    return $this->where('year', config('view.theme'));
  }
}