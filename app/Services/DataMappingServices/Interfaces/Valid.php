<?php

namespace App\Services\DataMappingServices\Interfaces;

interface Valid {
  public function isValidate(array $record, array $key): bool;
  public function getKeyForValidate(): array;
  public function getValidateMessage(): string;
}