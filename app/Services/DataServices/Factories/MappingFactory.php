<?php

namespace App\Services\DataServices\Factories;

use App\Helper\Role;

class MappingFactory
{
  protected $map = [
    Role::FLEET_SALES_EXECUTIVES => 'FleetSalesExecutives',
    Role::SALES_MANAGER => 'SalesManager',
    Role::RETAIL_SALES_CONSULTANTS => 'RetailSalesConsultants',
    Role::STOCK_CONTROLLER => 'StockController',
    Role::FI => 'FI',
    Role::PARTS_MANAGER => 'PartsManager',
    Role::PARTS_SALES_REP => 'PartsSalesRep',
    Role::SERVICE_MANAGER => 'ServiceManager',
    Role::SERVICE_ADVISERS => 'ServiceAdvisor',
    Role::TECHNICIAN => 'Technician',
  ];

  public function make(string $type): array
  {
      return theme_mappings($this->map[$type]);
  }
}