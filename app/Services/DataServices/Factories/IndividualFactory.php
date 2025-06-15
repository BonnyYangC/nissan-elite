<?php

namespace App\Services\DataServices\Factories;

use App\Helper\Defination;
use App\Helper\Role;
use App\Services\DataMappingServices\MonthlyDataMapping as Individual;
use App\Services\DataMappingServices as DMS;
use Illuminate\Contracts\Container\Container;

class IndividualFactory
{
  private $container;
  private $mappingFactory;

  protected $map = [
    Role::FLEET_SALES_EXECUTIVES => null,
    Role::SALES_MANAGER => null,
    Role::RETAIL_SALES_CONSULTANTS => null,
    Role::STOCK_CONTROLLER => null,
    Role::FI => null,
    Role::PARTS_MANAGER => null,
    Role::PARTS_SALES_REP => null,
    Role::SERVICE_MANAGER => null,
    Role::SERVICE_ADVISERS => null,
    Role::TECHNICIAN => null,
    Defination::ACTION_TYPE_VALIDATE => DMS\ValidationImpl\IndividualMonthly::class,
    Defination::ACTION_TYPE_SYNC => DMS\ImportationImpl\IndividualMonthly::class,
  ];

  public function __construct(Container $container, MappingFactory $mappingFactory) {
    $this->container = $container;
    $this->mappingFactory = $mappingFactory;
  }

  public function make(string $type, string $actionType): Individual
  {
      if (!array_key_exists($type, $this->map)) {
          throw new \InvalidArgumentException("Unknown individual type");
      }
      // here only use DMS\ImportationImpl\IndividualMonthly::class
      return $this->container->make($this->map[$actionType])->setMatricsMappingArray($this->mappingFactory->make($type));
  }
}