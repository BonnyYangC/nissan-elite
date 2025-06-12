<?php

namespace App\Services\ExportServices;

trait Exporter {
  protected $parameters;

  public function setParameters(array $parameters) {
    $this->parameters = $parameters;
    return $this;
  }
}
