<?php

namespace App\Services\DataMappingServices\Factories;

use App\Helper\Role;
use App\Services\DataMappingServices\MonthlyDataMapping as Individual;
use App\Services\DataMappingServices as DMS;
use Illuminate\Contracts\Container\Container;

class IndividualFactory
{
  private $container;
  protected $map = [
    Role::FLEET_SALES_EXECUTIVES => DMS\MonthlyDataImpl\FleetSalesExecutives::class,
    Role::SALES_MANAGER => DMS\MonthlyDataImpl\SalesManager::class,
    Role::RETAIL_SALES_CONSULTANTS => DMS\MonthlyDataImpl\RetailSalesConsultants::class,
    Role::STOCK_CONTROLLER => DMS\MonthlyDataImpl\StockController::class,
    Role::FI => DMS\MonthlyDataImpl\FI::class,
    Role::PARTS_MANAGER => DMS\MonthlyDataImpl\PartsManager::class,
    Role::PARTS_SALES_REP => DMS\MonthlyDataImpl\PartsSalesRep::class,
    Role::SERVICE_MANAGER => DMS\MonthlyDataImpl\ServiceManager::class,
    Role::SERVICE_ADVISERS => DMS\MonthlyDataImpl\ServiceAdvisor::class,
    Role::TECHNICIAN => DMS\MonthlyDataImpl\Technician::class,
  ];

  public function __construct(Container $container) {
    $this->container = $container;
  }

  public function make(string $type, string $actionType): Individual
  {
      if (!isset($this->map[$type])) {
          throw new \InvalidArgumentException("Unknown individual type");
      }

      return $this->container->make($this->map[$type], ['action' => $actionType]);
  }
}