<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class EventBuilder extends Builder
{
  public function loadAll(): self {
    return $this->select(
      'id',
      'title',
      'start',
      'end'
    );
  }

  public function byRegion(array $region): self {
    return $this->whereIn('region', $region)
      ->orderBy('id', 'DESC');
  }

  public function withIncentive(): self {
    return $this->with('incent');
  }
}