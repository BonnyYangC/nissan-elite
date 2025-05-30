<?php

namespace App\Services\DataMappingServices\Interfaces;

interface Ignore {
  public static function isIgnored(array $record, array $key): bool;
}
