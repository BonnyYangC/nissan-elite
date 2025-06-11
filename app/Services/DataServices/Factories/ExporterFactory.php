<?php

namespace App\Services\DataServices\Factories;

use App\Services\ExportServices as DES;
use Illuminate\Contracts\Container\Container;

class ExporterFactory
{
  private $container;
  protected $map = [
    'admin' => DES\Admin::class,
    'region_staff' => DES\RegionStaff::class,
    'user' => DES\User::class,
    'historical_export' => DES\LoyaltyHistorical::class,
    'territory_report' => DES\TerritoryReport::class,
    'ranking' => DES\Ranking::class,
  ];

  public function __construct(Container $container) {
    $this->container = $container;
  }

  public function make(string $type)
  {
      if (!isset($this->map[$type])) {
          throw new \InvalidArgumentException("Unknown exporter type");
      }

      return $this->container->make($this->map[$type]);
  }
}